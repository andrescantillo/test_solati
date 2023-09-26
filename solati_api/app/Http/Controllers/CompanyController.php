<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $companies = Company::All();
            LogActivity::addToLog('The record was showed success', 'true', 'ShowAllCompanies', json_encode(""));

            return $this->successResponse(CompanyResource::collection($companies), 'The record was showed success', 200);
        } catch (\Throwable $exception) {

            LogActivity::addToLog('The record could not be showed', 'false', 'ShowAllCompanies', json_encode(""), $exception->getMessage());
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['created_by' => Auth::user()->id]);

            Company::create($request->all());

            DB::commit();

            LogActivity::addToLog('The record was saved success', 'true', 'StoreCompany', json_encode($request->all()));
            return $this->successResponse([], 'The record was saved success', 200);
        } catch (\Throwable $exception) {
            DB::rollBack();

            LogActivity::addToLog('The record could not be saved', 'false', 'StoreCompany', json_encode($request->all()), $exception->getMessage());
            return $this->errorResponse('The record could not be saved', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        try {
            DB::beginTransaction();

            $society = Company::find($company->id);

            DB::commit();

            LogActivity::addToLog('The record was showed success', 'true', 'ShowOneCompany', json_encode(""));
            return $this->successResponse(CompanyResource::make($society), 'The record was showed success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be showed', 'false', 'ShowOneCompany', json_encode(""), $exception->getMessage());
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['updated_by' => Auth::user()->id]);
            $company->update($request->all());

            DB::commit();

            LogActivity::addToLog('The record was updated success', 'true', 'UpdateCompany', "");

            return $this->successResponse([], 'The record was updated success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be updated', 'false', 'UpdateCompany', '', $exception->getMessage());
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            DB::beginTransaction();

            $company->delete();

            DB::commit();

            LogActivity::addToLog('The record was deleted success', 'true', 'DeleteCompany', '');
            return $this->successResponse([], 'The record was deleted success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be deleted', 'false', 'DeleteCompany', '', $exception->getMessage());
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
