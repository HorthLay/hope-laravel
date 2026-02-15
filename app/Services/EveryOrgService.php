<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EveryOrgService
{
    protected $baseUrl;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->baseUrl = config('services.every.base_url', 'https://api.every.org/v0');
        $this->key = config('services.every.key');
        $this->secret = config('services.every.secret');
    }

    /**
     * Get HTTP client with authentication
     */
    protected function client()
    {
        // Check if credentials are configured
        if (empty($this->key) || empty($this->secret)) {
            Log::warning('Every.org API credentials not configured');
            return Http::baseUrl($this->baseUrl);
        }

        return Http::withBasicAuth($this->key, $this->secret)
            ->baseUrl($this->baseUrl)
            ->timeout(30)
            ->retry(3, 100);
    }

    /**
     * Get nonprofit information by slug
     * 
     * @param string $slug The nonprofit slug (e.g., 'your-nonprofit-name')
     * @return array|null
     */
    public function getNonprofit($slug)
    {
        try {
            $response = $this->client()->get("/nonprofits/{$slug}");

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch nonprofit from Every.org', [
                'slug' => $slug,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Exception fetching nonprofit from Every.org', [
                'slug' => $slug,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Verify API credentials are working
     * 
     * @return bool
     */
    public function testConnection()
    {
        try {
            $response = $this->client()->get('/nonprofits');
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Every.org connection test failed', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get donation information
     * 
     * @param string $donationId
     * @return array|null
     */
    public function getDonation($donationId)
    {
        try {
            $response = $this->client()->get("/donations/{$donationId}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Failed to fetch donation from Every.org', [
                'donationId' => $donationId,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }
}