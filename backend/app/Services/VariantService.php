<?php

namespace App\Services;

use App\Models\Variant;

class VariantsService{

    public function __construct()
    {
        $this->variants = new Variant();
    }

    /**
     * fetch variant list services.
     *
     * @param \App\Models\Variant $this->variants
     * @return object
     */
    public function fetchVariants()
    {
        return $this->variants::query()
        ->orderBy('created_at','desc')
        ->get();
    }

}