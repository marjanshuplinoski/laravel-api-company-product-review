<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Company as CompanyResource;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource;
use Validator;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Company $company)
    {
        $products = Product::all()->where('company_id', $company->id);
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully');


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Company $company)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'description' => 'required|string',
            'ships_from' => 'required|string',
            'price' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->ships_from = $request->ships_from;
        $product->price = $request->price;
        $product->user_id = auth()->user()->id;
        $company->products()->save($product);

        return $this->sendResponse(new CompanyResource($product), 'Product created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($company_id, $product_id)
    {
        $product = Product::where('id', '=', $product_id)->where('company_id', '=', $company_id)->first();

        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }

        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Company $company
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Company $company, Product $product)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'description' => 'required|string',
            'ships_from' => 'required|string',
            'price' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->ships_from = $request->ships_from;
        $product->price = $request->price;
        $product->user_id = auth()->user()->id;
        $company->products()->save($product);

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company, Product $product)
    {
        $product->delete();

        return $this->sendResponse([], 'Product deleted successfully.');

    }
}
