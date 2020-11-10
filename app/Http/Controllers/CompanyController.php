<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Company;
use Validator;
use App\Http\Resources\Company as CompanyResource;


class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return $this->sendResponse(CompanyResource::collection($companies),'Companies retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string',
            'description' => 'required|string',
            'address' => 'required|string'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $company = new Company();
        $company->name = $request->name;
        $company->description = $request->description;
        $company->address = $request->address;

        auth()->user()->companies()->save($company);

        return $this->sendResponse(new CompanyResource($company), 'Company created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);

        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(new CompanyResource($company), 'Product retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Company $company)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'description' => 'required',
            'address' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company->name = $input['name'];
        $company->description = $input['description'];
        $company->address = $input['address'];
        $company->save();

        return $this->sendResponse(new CompanyResource($company), 'Company updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Company $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return $this->sendResponse([], 'Company deleted successfully.');

    }
}
