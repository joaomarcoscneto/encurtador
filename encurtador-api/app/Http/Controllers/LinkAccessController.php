<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinkAccess\StoreLinkAccessService;
use App\Models\Link;

class LinkAccessController extends Controller
{
    public function store(Request $request, Link $link, StoreLinkAccessService $storeLinkAccessService)
    {
        $access =$storeLinkAccessService->run($link, $request);

        return response()->json($access);
    }
}
