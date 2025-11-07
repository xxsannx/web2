<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Prometheus\RenderTextFormat;
use Superbalist\LaravelPrometheusExporter\PrometheusExporter;

class MetricsController extends Controller
{
    public function metrics()
    {
        $exporter = app(PrometheusExporter::class);
        
        $renderer = new RenderTextFormat();
        $result = $renderer->render($exporter->getMetricFamilySamples());

        return response($result, 200)
            ->header('Content-Type', RenderTextFormat::MIME_TYPE);
    }
}
