<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ParseLog;
use App\Services\IpLocationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * 显示仪表板
     */
    public function index(Request $request)
    {
        // 今日数据
        $todayData = $this->getTodayStats();
        
        // 获取时间范围参数
        $dateRange = $request->get('range', '7days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        // 根据选择获取对应的数据
        $chartData = $this->getStatsData($dateRange, $startDate, $endDate);
        
        return view('admin.dashboard', compact('todayData', 'chartData', 'dateRange', 'startDate', 'endDate'));
    }

    /**
     * 获取今日统计数据
     */
    private function getTodayStats()
    {
        $today = Carbon::today();
        
        return [
            'new_users' => User::whereDate('created_at', $today)->count(),
            'total_parses' => ParseLog::whereDate('parse_date', $today)->count(),
            'success_parses' => ParseLog::whereDate('parse_date', $today)->where('is_success', true)->count(),
            'failed_parses' => ParseLog::whereDate('parse_date', $today)->where('is_success', false)->count(),
        ];
    }

    /**
     * 获取最近7天统计数据
     */
    private function getWeeklyStats()
    {
        return $this->getStatsData('7days');
    }

    /**
     * 获取统计数据（支持不同时间范围）
     */
    private function getStatsData($range = '7days', $startDate = null, $endDate = null)
    {
        // 判断是否为单天数据，如果是则按小时统计
        if ($this->isSingleDay($range, $startDate, $endDate)) {
            return $this->getHourlyStats($range, $startDate, $endDate);
        }
        
        // 多天数据按天统计
        return $this->getDailyStats($range, $startDate, $endDate);
    }

    /**
     * 判断是否为单天数据
     */
    private function isSingleDay($range, $startDate = null, $endDate = null)
    {
        if ($range === 'custom' && $startDate && $endDate) {
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);
            return $start->isSameDay($end);
        }
        
        return false;
    }

    /**
     * 获取按小时统计的数据（单天）
     */
    private function getHourlyStats($range, $startDate = null, $endDate = null)
    {
        $data = [];
        $targetDate = null;
        
        if ($range === 'custom' && $startDate) {
            $targetDate = Carbon::parse($startDate);
        } else {
            $targetDate = Carbon::today();
        }
        
        // 生成24小时的数据
        for ($hour = 0; $hour < 24; $hour++) {
            $hourStart = $targetDate->copy()->hour($hour)->minute(0)->second(0);
            $hourEnd = $hourStart->copy()->addHour()->subSecond();
            
            $data[] = [
                'date' => $targetDate->format('Y-m-d'),
                'hour' => $hour,
                'date_display' => sprintf('%02d:00', $hour),
                'datetime_display' => $hourStart->format('H:i'),
                'new_users' => User::whereBetween('created_at', [$hourStart, $hourEnd])->count(),
                'total_parses' => ParseLog::whereBetween('created_at', [$hourStart, $hourEnd])->count(),
                'success_parses' => ParseLog::whereBetween('created_at', [$hourStart, $hourEnd])
                    ->where('is_success', true)->count(),
                'failed_parses' => ParseLog::whereBetween('created_at', [$hourStart, $hourEnd])
                    ->where('is_success', false)->count(),
            ];
        }
        
        return $data;
    }

    /**
     * 获取按天统计的数据（多天）
     */
    private function getDailyStats($range, $startDate = null, $endDate = null)
    {
        $data = [];
        $dates = $this->getDateRange($range, $startDate, $endDate);
        
        foreach ($dates as $date) {
            $dateStr = $date->format('Y-m-d');
            $displayFormat = $this->getDisplayFormat($range);
            
            $data[] = [
                'date' => $dateStr,
                'date_display' => $date->format($displayFormat),
                'new_users' => User::whereDate('created_at', $date)->count(),
                'total_parses' => ParseLog::whereDate('parse_date', $date)->count(),
                'success_parses' => ParseLog::whereDate('parse_date', $date)->where('is_success', true)->count(),
                'failed_parses' => ParseLog::whereDate('parse_date', $date)->where('is_success', false)->count(),
            ];
        }
        
        return $data;
    }

    /**
     * 根据范围类型获取日期数组
     */
    private function getDateRange($range, $startDate = null, $endDate = null)
    {
        $dates = [];
        
        switch ($range) {
            case '7days':
                for ($i = 6; $i >= 0; $i--) {
                    $dates[] = Carbon::today()->subDays($i);
                }
                break;
                
            case '30days':
                for ($i = 29; $i >= 0; $i--) {
                    $dates[] = Carbon::today()->subDays($i);
                }
                break;
                
            case 'custom':
                if ($startDate && $endDate) {
                    $start = Carbon::parse($startDate);
                    $end = Carbon::parse($endDate);
                    
                    // 限制最大范围为90天
                    if ($start->diffInDays($end) > 90) {
                        $end = $start->copy()->addDays(90);
                    }
                    
                    $current = $start->copy();
                    while ($current->lte($end)) {
                        $dates[] = $current->copy();
                        $current->addDay();
                    }
                } else {
                    // 默认返回最近7天
                    for ($i = 6; $i >= 0; $i--) {
                        $dates[] = Carbon::today()->subDays($i);
                    }
                }
                break;
                
            default:
                for ($i = 6; $i >= 0; $i--) {
                    $dates[] = Carbon::today()->subDays($i);
                }
        }
        
        return $dates;
    }

    /**
     * 根据范围类型获取显示格式
     */
    private function getDisplayFormat($range)
    {
        switch ($range) {
            case '7days':
                return 'm/d';
            case '30days':
                return 'm/d';
            case 'custom':
                return 'm/d';
            default:
                return 'm/d';
        }
    }

    /**
     * API接口 - 获取今日数据
     */
    public function getTodayData()
    {
        return response()->json($this->getTodayStats());
    }

    /**
     * API接口 - 获取最近7天数据
     */
    public function getWeeklyData()
    {
        return response()->json($this->getWeeklyStats());
    }

    /**
     * API接口 - 获取指定范围的统计数据
     */
    public function getStatsDataApi(Request $request)
    {
        $range = $request->get('range', '7days');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        
        $data = $this->getStatsData($range, $startDate, $endDate);
        $isSingleDay = $this->isSingleDay($range, $startDate, $endDate);
        
        return response()->json([
            'data' => $data,
            'range' => $range,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_single_day' => $isSingleDay,
            'chart_type' => $isSingleDay ? 'hourly' : 'daily',
        ]);
    }

    /**
     * 获取今日按小时统计数据
     */
    public function getTodayHourlyData()
    {
        $data = $this->getHourlyStats('custom', Carbon::today()->format('Y-m-d'), Carbon::today()->format('Y-m-d'));
        
        return response()->json([
            'data' => $data,
            'chart_type' => 'hourly',
            'date' => Carbon::today()->format('Y-m-d'),
        ]);
    }

    /**
     * 显示解析记录列表
     */
    public function parseLogs(Request $request)
    {
        $query = ParseLog::with('user')
            ->orderBy('created_at', 'desc');

        // 日期筛选
        if ($request->filled('date')) {
            $query->whereDate('parse_date', $request->date);
        }

        // 状态筛选
        if ($request->filled('status')) {
            if ($request->status === 'success') {
                $query->where('is_success', true);
            } elseif ($request->status === 'failed') {
                $query->where('is_success', false);
            }
        }

        // 平台筛选
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        // 用户筛选
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // IP筛选
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        $logs = $query->paginate(20);

        // 获取筛选选项数据
        $platforms = ParseLog::distinct()->pluck('platform')->filter()->sort();
        
        return view('admin.parse-logs', compact('logs', 'platforms'));
    }

    /**
     * 显示解析记录详情
     */
    public function parseLogDetail($id)
    {
        $log = ParseLog::with('user')->findOrFail($id);
        return view('admin.parse-log-detail', compact('log'));
    }

    /**
     * API接口 - 获取解析记录列表
     */
    public function getParseLogsData(Request $request)
    {
        $query = ParseLog::with('user:id,name,email')
            ->orderBy('created_at', 'desc');

        // 应用筛选条件
        if ($request->filled('date')) {
            $query->whereDate('parse_date', $request->date);
        }

        if ($request->filled('status')) {
            if ($request->status === 'success') {
                $query->where('is_success', true);
            } elseif ($request->status === 'failed') {
                $query->where('is_success', false);
            }
        }

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        $logs = $query->paginate(20);

        return response()->json($logs);
    }

    /**
     * 显示新用户详细列表
     */
    public function newUsers(Request $request)
    {
        $query = User::orderBy('created_at', 'desc');

        // 日期筛选
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            // 默认显示今日新用户
            $query->whereDate('created_at', Carbon::today());
        }

        // 搜索筛选
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(20);

        return view('admin.new-users', compact('users'));
    }

    /**
     * 获取解析记录IP统计
     */
    public function getIpStats(Request $request)
    {
        $dateRange = $request->get('range', 'today');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $query = ParseLog::select('ip_address', DB::raw('COUNT(*) as count'))
            ->groupBy('ip_address')
            ->orderBy('count', 'desc');

        // 应用日期筛选
        switch ($dateRange) {
            case 'today':
                $query->whereDate('parse_date', Carbon::today());
                break;
            case '7days':
                $query->where('parse_date', '>=', Carbon::today()->subDays(6));
                break;
            case '30days':
                $query->where('parse_date', '>=', Carbon::today()->subDays(29));
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('parse_date', [$startDate, $endDate]);
                }
                break;
        }

        $ipStats = $query->limit(100)->get();

        // 获取IP位置信息
        $ipLocationService = new IpLocationService();
        $ips = $ipStats->pluck('ip_address')->toArray();
        $locations = $ipLocationService->getBatchLocations($ips);

        // 合并位置信息
        $ipStats = $ipStats->map(function ($item) use ($locations) {
            $location = $locations[$item->ip_address] ?? [];
            $item->location = $location;
            $item->location_text = app(IpLocationService::class)->formatLocation($location);
            return $item;
        });

        return response()->json([
            'ip_stats' => $ipStats,
            'total_unique_ips' => $ipStats->count(),
            'total_requests' => $ipStats->sum('count'),
            'date_range' => $dateRange,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * 批量获取IP位置信息
     */
    public function batchIpLocation(Request $request)
    {
        $request->validate([
            'ips' => 'required|array',
            'ips.*' => 'ip'
        ]);

        $ips = $request->ips;
        $ipLocationService = new IpLocationService();
        $locations = $ipLocationService->getBatchLocations($ips);

        // 格式化位置信息
        $result = [];
        foreach ($locations as $ip => $location) {
            $result[$ip] = [
                'location' => $location,
                'location_text' => $ipLocationService->formatLocation($location)
            ];
        }

        return response()->json($result);
    }
}