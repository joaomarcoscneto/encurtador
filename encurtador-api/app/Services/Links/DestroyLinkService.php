<?php

namespace App\Services\Links;

use App\Models\Link;
use Illuminate\Support\Str;

class DestroyLinkService
{
    public function run($link)
    {
        $link->delete();
        return True;
    }
}
