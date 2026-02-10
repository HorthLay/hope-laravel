<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SiteVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'referrer',
        'device_type',
        'browser',
        'platform',
        'country',
        'city',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    /**
     * Get unique visitors count
     */
    public static function uniqueVisitors($startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate) {
            $query->where('visited_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('visited_at', '<=', $endDate);
        }
        
        return $query->distinct('ip_address')->count('ip_address');
    }

    /**
     * Get total visits count
     */
    public static function totalVisits($startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate) {
            $query->where('visited_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('visited_at', '<=', $endDate);
        }
        
        return $query->count();
    }

    /**
     * Get visits by device type
     */
    public static function byDeviceType($startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate) {
            $query->where('visited_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('visited_at', '<=', $endDate);
        }
        
        return $query->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->get();
    }

    /**
     * Get top pages
     */
    public static function topPages($limit = 10, $startDate = null, $endDate = null)
    {
        $query = self::query();
        
        if ($startDate) {
            $query->where('visited_at', '>=', $startDate);
        }
        
        if ($endDate) {
            $query->where('visited_at', '<=', $endDate);
        }
        
        return $query->select('page_url', DB::raw('count(*) as visits'))
            ->groupBy('page_url')
            ->orderBy('visits', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get visits trend by day
     */
    public static function visitsTrend($days = 7)
    {
        return self::query()
            ->where('visited_at', '>=', now()->subDays($days))
            ->select(DB::raw('DATE(visited_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}