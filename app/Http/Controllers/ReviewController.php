<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\Review as ReviewResource;
use App\Models\Company;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Validator;

class ReviewController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $review = Review::all()->where('product_id', $product->id);
        return $this->sendResponse(ReviewResource::collection($review), 'Reviews retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'review' => 'required|string',
            'rating' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $review = new Review();
        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = auth()->user()->id;
        $product->reviews()->save($review);

        return $this->sendResponse(new ReviewResource($review), 'Review created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show($product_id,$review_id)
    {
        $review = Review::where('id', '=', $review_id)->where('product_id', '=', $product_id)->first();

        if (is_null($review)) {
            return $this->sendError('Review not found.');
        }

        return $this->sendResponse(new ReviewResource($review), 'Review retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Review $review)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'review' => 'required|string',
            'rating' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $review->review = $request->review;
        $review->rating = $request->rating;
        $review->user_id = auth()->user()->id;
        $product->reviews()->save($review);

        return $this->sendResponse(new ReviewResource($review), 'Review updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $review->delete();

        return $this->sendResponse([], 'Review deleted successfully.');

    }
}
