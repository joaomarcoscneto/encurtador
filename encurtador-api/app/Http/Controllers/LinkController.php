<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLinkRequest;
use App\Http\Requests\UpdateLinkRequest;
use App\Models\Link;
use App\Services\Links\DestroyLinkService;
use App\Services\Links\ListLinkService;
use App\Services\Links\StoreLinkService;
use App\Services\Links\UpdateLinkService;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('generate.slug')->only(['store', 'update']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ListLinkService $listLinkService)
    {
        return response()->json($listLinkService->run());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request, StoreLinkService $storeLinkService)
    {
        $link = $storeLinkService->run($request->all());

        return response()->json($link, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link)
    {
        return response()->json($link);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLinkRequest $request, Link $link, UpdateLinkService $updateLinkService)
    {
        $link = $updateLinkService->run($link, $request->all());
        return response()->json($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link, DestroyLinkService $destroyLinkService)
    {
        $destroyLinkService->run($link);
        return response()->json([], 204);
    }
}
