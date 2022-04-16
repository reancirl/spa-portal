<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarangayResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\RegionResource;
use App\Models\Barangay;
use App\Models\City;
use App\Models\Province;
use App\Models\Region;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use FormatResponse;


    /**
     * Display a listing of the resource.
     *
     * @param App\Models\Region $region
     * @return \Illuminate\Http\Response
     */

    public function region_provinces(Region $region)
    {
        try {
            return $this->successResourceResponse(
                ProvinceResource::collection(Province::where('region_code', $region->code)->get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render region provinces.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Models\Province $province
     * @return \Illuminate\Http\Response
     */

    public function province_cities(Province $province)
    {
        try {
            return $this->successResourceResponse(
                CityResource::collection(City::where('province_id', $province->id)->get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render region provinces.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param App\Models\City $city
     * @return \Illuminate\Http\Response
     */

    public function cities_barangays(City $city)
    {
        try {
            return $this->successResourceResponse(
                BarangayResource::collection(Barangay::where('city_id', $city->id)->get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render region provinces.'
            );
        }
    }



    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index_region()
    {
        try {
            return $this->successResourceResponse(
                RegionResource::collection(Region::get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render region.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_barangay()
    {
        try {
            return $this->successResourceResponse(
                BarangayResource::collection(Barangay::get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render Barangay.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_city()
    {
        try {
            return $this->successResourceResponse(
                CityResource::collection(City::get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render City.'
            );
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_province()
    {
        try {
            return $this->successResourceResponse(
                ProvinceResource::collection(Province::get())
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to render Province.'
            );
        }
    }
}
