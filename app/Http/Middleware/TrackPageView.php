<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackPageView
{
    /**
     * URL patterns to exclude from tracking
     * (admin, API, static files, etc.)
     */
    private array $exclude = [
        'admin',
        'login',
        'logout',
        'register',
        'password',
        'api',
        '_ignition',
        'storage',
        'livewire',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        // Skip non-GET requests, AJAX, and excluded paths
        if ($request->isMethod('GET') && !$request->ajax() && $this->shouldTrack($request)) {
            try {
                PageView::create([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'url'        => $request->path(),
                    'session_id' => $request->session()->getId(),
                ]);
            } catch (\Exception $e) {
                // Fail silently — never break the website for tracking errors
            }
        }

        return $next($request);
    }

    private function shouldTrack(Request $request): bool
    {
        foreach ($this->exclude as $path) {
            if (str_starts_with($request->path(), $path)) {
                return false;
            }
        }
        return true;
    }
}
