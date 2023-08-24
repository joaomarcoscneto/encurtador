<?php

namespace App\Services\Links;

use App\Models\Link;

class ListLinkService
{
    public function run()
    {
        return Link::all();
    }
}
