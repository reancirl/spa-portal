<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SettingsService
{

    /**
     * Get settings
     *
     * @param string $slug
     * @return mixed
     */
    public function getValue($slug)
    {
        $slug = DB::table('settings')->where('slug', $slug)->first();

        if (!$slug) {
            return null;
        }

        return $slug->value;
    }

    /**
     * Update settings
     *
     * @param string $slug
     * @param mixed $value
     * @return mixed
     */
    public function setValue($slug, $value)
    {
        if (!$value) {
            return null;
        }

        $settings = $this->getValue($slug);

        if (!$settings) {
            return null;
        }

        DB::table('settings')
            ->where('slug', $slug)
            ->update(['value' => $value]);

        return $value;
    }
}
