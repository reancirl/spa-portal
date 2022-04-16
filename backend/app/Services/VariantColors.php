<?php

namespace App\Services;

use App\Models\VariantColor;

class VariantColorsService{

    public function __construct()
    {
        $this->variantColors = new VariantColor();
    }

    /**
     * fetch variant colors list services.
     *
     * @param \App\Models\VariantColor $this->variantColors
     * @return object
     */
    public function fetchVariantColors()
    {
        return $this->variantColors::query()
        ->orderBy('created_at','desc')
        ->get();
    }

}