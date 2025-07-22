<!-- 高级时间范围选择器组件 -->

<script>
    // 北京时间辅助函数
    function getBeijingDate() {
        const now = new Date();
        const beijingTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
        return beijingTime;
    }

    function getBeijingDateString(date = null) {
        const targetDate = date || getBeijingDate();
        const year = targetDate.getFullYear();
        const month = String(targetDate.getMonth() + 1).padStart(2, '0');
        const day = String(targetDate.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    function getBeijingDateOffset(days) {
        const beijingDate = getBeijingDate();
        beijingDate.setDate(beijingDate.getDate() + days);
        return beijingDate;
    }

    // 设置快速范围
    function setQuickRange(range) {
        const today = getBeijingDate();
        let startDate, endDate, displayText;

        switch(range) {
            case 'today':
                startDate = endDate = getBeijingDateString(today);
                displayText = '今天(按小时统计)';
                break;
            case 'yesterday':
                const yesterday = getBeijingDateOffset(-1);
                startDate = endDate = getBeijingDateString(yesterday);
                displayText = '昨天';
                break;
            case '7days':
                const sevenDaysAgo = getBeijingDateOffset(-6);
                startDate = getBeijingDateString(sevenDaysAgo);
                endDate = getBeijingDateString(today);
                displayText = '最近7天';
                break;
            case '30days':
                const thirtyDaysAgo = getBeijingDateOffset(-29);
                startDate = getBeijingDateString(thirtyDaysAgo);
                endDate = getBeijingDateString(today);
                displayText = '最近30天';
                break;
            case 'thisMonth':
                const thisMonthStart = new Date(today.getFullYear(), today.getMonth(), 1);
                startDate = getBeijingDateString(thisMonthStart);
                endDate = getBeijingDateString(today);
                displayText = '本月';
                break;
            case 'lastMonth':
                const lastMonthStart = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                const lastMonthEnd = new Date(today.getFullYear(), today.getMonth(), 0);
                startDate = getBeijingDateString(lastMonthStart);
                endDate = getBeijingDateString(lastMonthEnd);
                displayText = '上月';
                break;
        }

        // 更新显示
        const displayElement = document.getElementById('currentRangeDisplay');
        if (displayElement) {
            displayElement.textContent = displayText;
        }

        // 更新图表
        if (typeof updateChart === 'function') {
            updateChart('custom', startDate, endDate);

            // 更新URL（可选）
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.history.pushState({}, '', url);

            // 更新主页面的表单选择器
            if (document.getElementById('rangeSelect')) {
                document.getElementById('rangeSelect').value = 'custom';
                const startInput = document.querySelector('input[name="start_date"]');
                const endInput = document.querySelector('input[name="end_date"]');
                if (startInput) startInput.value = startDate;
                if (endInput) endInput.value = endDate;
                const customDateRange = document.getElementById('customDateRange');
                if (customDateRange) customDateRange.style.display = 'flex';
            }
        } else {
            // 如果没有updateChart函数，则刷新页面
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.location.href = url.toString();
        }
    }

    // 应用自定义范围
    function applyCustomRange() {
        const startDate = document.getElementById('customStartDate').value;
        const endDate = document.getElementById('customEndDate').value;

        if (!startDate || !endDate) {
            alert('请选择开始和结束日期');
            return;
        }

        if (startDate > endDate) {
            alert('开始日期不能晚于结束日期');
            return;
        }

        // 检查日期范围是否超过90天
        const start = new Date(startDate);
        const end = new Date(endDate);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffDays > 90) {
            alert('日期范围不能超过90天');
            return;
        }

        const displayText = `${startDate} 至 ${endDate}`;
        const displayElement = document.getElementById('currentRangeDisplay');
        if (displayElement) {
            displayElement.textContent = displayText;
        }

        // 更新图表
        if (typeof updateChart === 'function') {
            updateChart('custom', startDate, endDate);

            // 更新URL（可选）
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.history.pushState({}, '', url);

            // 更新主页面的表单选择器
            if (document.getElementById('rangeSelect')) {
                document.getElementById('rangeSelect').value = 'custom';
                const startInput = document.querySelector('input[name="start_date"]');
                const endInput = document.querySelector('input[name="end_date"]');
                if (startInput) startInput.value = startDate;
                if (endInput) endInput.value = endDate;
                const customDateRange = document.getElementById('customDateRange');
                if (customDateRange) customDateRange.style.display = 'flex';
            }
        } else {
            // 如果没有updateChart函数，则刷新页面
            const url = new URL(window.location);
            url.searchParams.set('range', 'custom');
            url.searchParams.set('start_date', startDate);
            url.searchParams.set('end_date', endDate);
            window.location.href = url.toString();
        }
    }

    // 初始化日期输入框
    document.addEventListener('DOMContentLoaded', function() {
        const customStartDate = document.getElementById('customStartDate');
        const customEndDate = document.getElementById('customEndDate');

        if (customStartDate && customEndDate) {
            const today = getBeijingDateString();
            const sevenDaysAgo = getBeijingDateString(getBeijingDateOffset(-6));

            customStartDate.value = sevenDaysAgo;
            customEndDate.value = today;

            // 设置最大日期为今天
            customStartDate.max = today;
            customEndDate.max = today;
        }
    });
</script>
