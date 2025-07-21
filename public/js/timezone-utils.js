/**
 * 北京时间处理工具函数
 */

// 获取北京时间的Date对象
function getBeijingDate() {
    const now = new Date();
    const beijingTime = new Date(now.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    return beijingTime;
}

// 获取北京时间的日期字符串 (YYYY-MM-DD)
function getBeijingDateString(date = null) {
    const targetDate = date || getBeijingDate();
    const year = targetDate.getFullYear();
    const month = String(targetDate.getMonth() + 1).padStart(2, '0');
    const day = String(targetDate.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
}

// 获取北京时间的日期时间字符串 (YYYY-MM-DD HH:mm:ss)
function getBeijingDateTimeString(date = null) {
    const targetDate = date || getBeijingDate();
    const year = targetDate.getFullYear();
    const month = String(targetDate.getMonth() + 1).padStart(2, '0');
    const day = String(targetDate.getDate()).padStart(2, '0');
    const hours = String(targetDate.getHours()).padStart(2, '0');
    const minutes = String(targetDate.getMinutes()).padStart(2, '0');
    const seconds = String(targetDate.getSeconds()).padStart(2, '0');
    return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
}

// 获取北京时间偏移指定天数的Date对象
function getBeijingDateOffset(days) {
    const beijingDate = getBeijingDate();
    beijingDate.setDate(beijingDate.getDate() + days);
    return beijingDate;
}

// 格式化任意时间为北京时间显示
function formatToBeijingTime(dateString, format = 'YYYY-MM-DD HH:mm:ss') {
    if (!dateString) return '';
    
    const date = new Date(dateString);
    const beijingTime = new Date(date.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    
    const year = beijingTime.getFullYear();
    const month = String(beijingTime.getMonth() + 1).padStart(2, '0');
    const day = String(beijingTime.getDate()).padStart(2, '0');
    const hours = String(beijingTime.getHours()).padStart(2, '0');
    const minutes = String(beijingTime.getMinutes()).padStart(2, '0');
    const seconds = String(beijingTime.getSeconds()).padStart(2, '0');
    
    switch(format) {
        case 'YYYY-MM-DD':
            return `${year}-${month}-${day}`;
        case 'HH:mm:ss':
            return `${hours}:${minutes}:${seconds}`;
        case 'YYYY-MM-DD HH:mm':
            return `${year}-${month}-${day} ${hours}:${minutes}`;
        case 'MM-DD HH:mm':
            return `${month}-${day} ${hours}:${minutes}`;
        default:
            return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }
}

// 获取北京时间的本月第一天
function getBeijingMonthStart(date = null) {
    const targetDate = date || getBeijingDate();
    return new Date(targetDate.getFullYear(), targetDate.getMonth(), 1);
}

// 获取北京时间的上月最后一天
function getBeijingLastMonthEnd(date = null) {
    const targetDate = date || getBeijingDate();
    return new Date(targetDate.getFullYear(), targetDate.getMonth(), 0);
}

// 获取北京时间的上月第一天
function getBeijingLastMonthStart(date = null) {
    const targetDate = date || getBeijingDate();
    return new Date(targetDate.getFullYear(), targetDate.getMonth() - 1, 1);
}

// 检查两个日期是否为同一天（北京时间）
function isSameDayBeijing(date1, date2) {
    const d1 = new Date(date1.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    const d2 = new Date(date2.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    
    return d1.getFullYear() === d2.getFullYear() &&
           d1.getMonth() === d2.getMonth() &&
           d1.getDate() === d2.getDate();
}

// 计算两个日期之间的天数差（北京时间）
function daysDifferenceBeijing(startDate, endDate) {
    const start = new Date(startDate.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    const end = new Date(endDate.toLocaleString("en-US", {timeZone: "Asia/Shanghai"}));
    
    const diffTime = Math.abs(end - start);
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
}

// 导出函数（如果使用模块系统）
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        getBeijingDate,
        getBeijingDateString,
        getBeijingDateTimeString,
        getBeijingDateOffset,
        formatToBeijingTime,
        getBeijingMonthStart,
        getBeijingLastMonthEnd,
        getBeijingLastMonthStart,
        isSameDayBeijing,
        daysDifferenceBeijing
    };
}