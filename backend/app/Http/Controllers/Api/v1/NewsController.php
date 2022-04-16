<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Services\NewsService;
use App\Traits\FormatResponse;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource_;

class NewsController extends Controller
{

    use FormatResponse;

    /**
     * Display a listing of the resource.
     *i
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = News::when(auth()->user()->dealer_id, function ($query) use ($request) {
                $query->whereJsonContains('dealers', auth()->user()->dealer_id)
                    ->orWhereNull('dealers');
            })
                ->where('status', true)
                ->orderBy('precedence');

            $data = $this->paginate($query, $request->per_page, $request->all());

            return $this->successResourceResponse(
                NewsResource::collection($data)
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get news.'
            );
        }
    }

    /**
     * Store News.
     *
     * @param  \Illuminate\Http\NewsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsRequest $request)
    {
        try {
            return $this->formatSuccessResponse(
                [
                    new NewsResource(News::create(array_merge($request->validated(), [
                        'created_by_user_id' => auth()->user()->id,
                        'updated_by_user_id' => auth()->user()->id
                    ])))
                ],
                'News successfully created.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create News'
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->successResponse(
                new NewsResource(News::findOrFail($id))
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to get Color.'
            );
        }
    }

    /**
     * Update News.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NewsRequest $request, $id)
    {
        try {
            $news = News::findOrFail($id);

            $news->update($request->validated());

            return $this->formatSuccessResponse(
                [
                    new NewsResource($news)
                ],
                'News successfully updated.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to update News'
            );
        }
    }

    /**
     * Remove News.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);

            $news->delete();

            return $this->formatSuccessResponse(
                [],
                'News successfully deleted.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse(
                'Failed to create News'
            );
        }
    }
}
