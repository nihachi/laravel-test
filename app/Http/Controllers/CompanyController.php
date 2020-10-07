<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return response()->json($companies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|unique:companies,email',
        ]);

        if (Company::create($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
        }

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        return response()->json($company, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        $company = Company::find($id);
        
        if (!$company) {
            return response()->json([ 'status' => 'error' ], 404);
        }

        if ( $company->update($request->all()) ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error', 'data' => $request ];
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([ 'status' => 'success' ], 200);
    }

    public function upload(Request $request){
        if ($request->has('image')){
            $pathToFile = $request->file('image')->store('images', 'public');
    
            return $pathToFile;
        }
    }
}
