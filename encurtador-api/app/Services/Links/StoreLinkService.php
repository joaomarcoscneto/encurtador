<?php

namespace App\Services\Links;

use App\Models\Link;

class StoreLinkService
{
    public function run($form)
    {
        return Link::create($form);
    }
}
