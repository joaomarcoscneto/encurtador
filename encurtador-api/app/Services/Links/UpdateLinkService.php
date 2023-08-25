<?php

namespace App\Services\Links;

use App\Models\Link;

class UpdateLinkService
{
    public function run($link, $form)
    {
        $link->update($form);
        return Link::find($link->id);
    }
}
