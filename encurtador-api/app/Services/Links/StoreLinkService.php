<?php

namespace App\Services\Links;

use App\Models\Link;
use Illuminate\Support\Str;

class StoreLinkService
{
    public function run($form)
    {
        return Link::create($form);
    }
}
