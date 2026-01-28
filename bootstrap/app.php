<?php

use App\Http\Middleware\checkHariPengumuman;
use App\Http\Middleware\CheckGuruAccess;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsGuru;
use App\Http\Middleware\IsSiswa;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\TrackVisitors;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            "isAdmin" => IsAdmin::class,
            "isSiswa" => IsSiswa::class,
            "isGuru"  => IsGuru::class,
            "checkHariPengumuman" => checkHariPengumuman::class,
            "guruAccess" => CheckGuruAccess::class,
        ]);
        $middleware->appendToGroup('web', [
            TrackVisitors::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
