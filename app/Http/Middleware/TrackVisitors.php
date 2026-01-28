<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Landing\StatSections;

class TrackVisitors
{
    public function handle(Request $request, Closure $next)
    {
        if (
            $request->isMethod('GET')
            && !$request->ajax()
            && !$request->routeIs('livewire.*')
        ) {
            if (!session()->has('counted_visit')) {
                $stat = StatSections::where('label', 'Pengunjung Website')->first();
                if ($stat && $stat->is_editable) {
                    $stat->increment('value');
                    session()->put('counted_visit', true);
                    session()->save();
                }
            }
        }

        return $next($request);
    }
}
