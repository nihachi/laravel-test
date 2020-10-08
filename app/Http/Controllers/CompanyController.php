<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
        $validator = Validator::make($request->all(),[
            'name'   => 'required|string|max:255',
            'email'  => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => 'error', 'errors' => $validator->errors()]);
        }

        $company_logo = "";
        
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = '/app/logos/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $company_logo = '/storage' . $name;
        } else {
            $company_logo = $request->logo;
        }

        $company = new Company();
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $company_logo;

        if ($company->save()) {
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

        $validator = Validator::make($request->all(),[
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'status' => 'error', 'errors' => $validator->errors()]);
        }

        $company_logo = "";
        
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = '/app/logos/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $company_logo = '/storage' . $name;
        } else {
            $company_logo = $request->logo;
        }

        $company = Company::find($id);
        $company->name = $request->name;
        $company->email = $request->email;
        $company->logo = $company_logo;
        
        if (!$company) {
            return response()->json([ 'status' => 'error' ], 404);
        }

        if ( $company->save() ) {
            $response = [ 'status' => 'success' ];
        } else {
            $response = [ 'status' => 'error' ];
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

    // Import Company from seeder
    public function importCompany(){
        \Artisan::call('db:seed', array('--class' => 'CompanySeeder'));
        return response()->json([ 'status' => 'success' ], 200);
    }
}
