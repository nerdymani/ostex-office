<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiClient
{
    private string $base;

    public function __construct()
    {
        $this->base = rtrim(config('admin_api.base_url'), '/');
    }

    public function get(string $endpoint, array $params = []): array
    {
        try {
            $response = Http::timeout(config('admin_api.timeout', 5))
                ->accept('application/json')
                ->get($this->base . $endpoint, $params);
            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? $data ?? [];
            }
            return [];
        } catch (\Exception $e) {
            Log::error('E-Office API GET failed', ['endpoint' => $endpoint, 'error' => $e->getMessage()]);
            return [];
        }
    }

    public function isOnline(): bool
    {
        try {
            $url = str_replace('/v1', '', $this->base) . '/health';
            return Http::timeout(3)->get($url)->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
