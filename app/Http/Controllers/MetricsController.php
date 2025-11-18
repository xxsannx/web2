<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetricsController extends Controller
{
    public function metrics()
    {
        $uptime = time() - LARAVEL_START;

        $metrics = [];

        // Basic Laravel info
        $metrics[] = "# HELP laravel_app_uptime_seconds Laravel application uptime";
        $metrics[] = "# TYPE laravel_app_uptime_seconds counter";
        $metrics[] = "laravel_app_uptime_seconds {$uptime}";

        // Request count (simple)
        $metrics[] = "# HELP laravel_request_total Total HTTP requests since boot";
        $metrics[] = "# TYPE laravel_request_total counter";
        $metrics[] = "laravel_request_total " . request()->server('REQUEST_TIME_FLOAT');

        return response(implode("\n", $metrics), 200)
            ->header('Content-Type', 'text/plain');
    }
}
