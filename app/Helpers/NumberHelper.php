<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Format large numbers with K, M, B suffixes
     * 
     * @param int|float $number
     * @param int $precision
     * @return string
     */
    public static function formatNumber($number, $precision = 1)
    {
        if ($number < 1000) {
            return (string) $number;
        }

        $suffixes = ['', 'K', 'M', 'B', 'T'];
        $suffixIndex = 0;

        while ($number >= 1000 && $suffixIndex < count($suffixes) - 1) {
            $number /= 1000;
            $suffixIndex++;
        }

        // Remove unnecessary decimal zeros
        $formatted = number_format($number, $precision);
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted . $suffixes[$suffixIndex];
    }

    /**
     * Format bytes to human readable size
     * 
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    public static function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Format duration in seconds to readable format
     * 
     * @param int $seconds
     * @return string
     */
    public static function formatDuration($seconds)
    {
        if ($seconds < 60) {
            return $seconds . 's';
        }

        if ($seconds < 3600) {
            $minutes = floor($seconds / 60);
            $secs = $seconds % 60;
            return $secs > 0 ? "{$minutes}m {$secs}s" : "{$minutes}m";
        }

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        return $minutes > 0 ? "{$hours}h {$minutes}m" : "{$hours}h";
    }
}