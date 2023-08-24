<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use App\Models\Link;

class GenerateSlug
{
    public function handle($request, Closure $next)
    {
        $form = $request->all();

        if (!isset($form['slug'])) {
            do {
                $newSlug = Str::random(rand(6, 8));
            } while(Link::where('slug', $newSlug)->exists());

            $form['slug'] = $newSlug;
            $request->merge(['slug' => $newSlug]);
        }

        return $next($request);
    }
}
