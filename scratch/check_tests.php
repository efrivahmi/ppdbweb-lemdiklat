<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pendaftaran\CustomTest;

$tests = CustomTest::select('nama_test', 'category', 'is_active')->get();
foreach ($tests as $test) {
    echo "Name: {$test->nama_test} | Category: {$test->category} | Active: " . ($test->is_active ? 'Yes' : 'No') . "\n";
}
