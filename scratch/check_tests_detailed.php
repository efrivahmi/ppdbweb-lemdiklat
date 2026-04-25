<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Pendaftaran\CustomTest;
use App\Models\Pendaftaran\CustomTestAnswer;

$tests = CustomTest::select('id', 'nama_test', 'category', 'is_active')->get();
foreach ($tests as $test) {
    $count = CustomTestAnswer::where('custom_test_id', $test->id)->distinct('user_id')->count('user_id');
    echo "ID: {$test->id} | Name: {$test->nama_test} | Category: {$test->category} | Active: " . ($test->is_active ? 'Yes' : 'No') . " | Participants: {$count}\n";
}
