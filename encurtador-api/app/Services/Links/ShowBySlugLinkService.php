<?php

namespace App\Services\Links;

use App\Models\Link;

class ShowBySlugLinkService
{
    public function run($slug)
    {
        return Link::query()->where('slug', $slug)->first();
    }
}
