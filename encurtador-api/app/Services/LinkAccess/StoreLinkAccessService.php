<?php

namespace App\Services\LinkAccess;

class StoreLinkAccessService
{
    public function run($link, $request)
    {
        $access = $link->accesses()->create([
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $link->increment('views_count', 1);

        return $access;
    }
}
