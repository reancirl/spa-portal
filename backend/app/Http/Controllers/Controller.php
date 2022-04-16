<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Paginates data
     *
     * @param \Illuminate\Database\Eloquent\Builder $data
     * @param int $per_page
     * @param mixed $request
     */
    protected function paginate($data, $per_page, $request)
    {
        if (!$per_page || $per_page == -1) {
            return $data->get();
        }

        return $data->paginate($per_page)->appends($request);
    }
}
