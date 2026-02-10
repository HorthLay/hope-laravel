<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'setting_key',
        'setting_value',
        'setting_type',
        'description',
    ];

    /**
     * Get a setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('setting_key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return static::castValue($setting->setting_value, $setting->setting_type);
        });
    }

    /**
     * Set a setting value by key.
     *
     * @param string $key
     * @param mixed $value
     * @param string $type
     * @return bool
     */
    public static function set($key, $value, $type = 'text')
    {
        $setting = static::updateOrCreate(
            ['setting_key' => $key],
            [
                'setting_value' => static::prepareValue($value, $type),
                'setting_type' => $type,
            ]
        );

        Cache::forget("setting_{$key}");

        return $setting->wasRecentlyCreated || $setting->wasChanged();
    }

    /**
     * Get all settings as key-value array.
     *
     * @return array
     */
    public static function getAllSettings()
    {
        return Cache::remember('all_settings', 3600, function () {
            $settings = static::query()->get();
            
            return $settings->mapWithKeys(function ($setting) {
                return [
                    $setting->setting_key => static::castValue(
                        $setting->setting_value, 
                        $setting->setting_type
                    )
                ];
            })->toArray();
        });
    }

    /**
     * Clear settings cache.
     */
    public static function clearCache()
    {
        Cache::forget('all_settings');
        
        static::query()->get()->each(function ($setting) {
            Cache::forget("setting_{$setting->setting_key}");
        });
    }

    /**
     * Cast value based on type.
     *
     * @param mixed $value
     * @param string $type
     * @return mixed
     */
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'number':
                return is_numeric($value) ? (int) $value : $value;
            case 'json':
                return json_decode($value, true);
            case 'text':
            default:
                return $value;
        }
    }

    /**
     * Prepare value for storage.
     *
     * @param mixed $value
     * @param string $type
     * @return string
     */
    protected static function prepareValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return $value ? 'true' : 'false';
            case 'json':
                return json_encode($value);
            case 'number':
            case 'text':
            default:
                return (string) $value;
        }
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting_{$setting->setting_key}");
            Cache::forget('all_settings');
        });

        static::deleted(function ($setting) {
            Cache::forget("setting_{$setting->setting_key}");
            Cache::forget('all_settings');
        });
    }
}