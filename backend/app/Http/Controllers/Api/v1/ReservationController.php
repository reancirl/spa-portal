<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    use FormatResponse;
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Reservation::ofDealer(auth()->user()->dealer_id);

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                Reservation::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to fetch reservation '
            );
        }
    }

    /**
     * Store reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [new ReservationResource(Reservation::create(array_merge($request->validated(), [
                    'created_by_user_id' => auth()->user()->id
                ])))],
                'reservation successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create reservation'
            );
        }
    }


    /**
     * Update reservation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->update(array_merge($request->validated(), [
                'updated_by_user_id' => auth()->user()->id
            ]));
            return $this->formatSuccessResponse(
                [new ReservationResource($reservation)],
                'reservation successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update reservation'
            );
        }
    }

    /**
     * Remove reservation.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();
            return $this->formatSuccessResponse(
                [],
                'reservation successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to delete reservation'
            );
        }
    }
}
