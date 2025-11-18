<?php
header('Content-Type: text/plain');

$start = microtime(true);

// simulasi proses request atau App logic
usleep(rand(10000, 50000)); // 10-50 ms

$duration = microtime(true) - $start;

echo "app_request_duration_seconds $duration\n";
