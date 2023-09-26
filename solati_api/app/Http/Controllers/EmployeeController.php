<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $employees = Employee::All();
            LogActivity::addToLog('The record was showed success', 'true', 'ShowAllEmployees', json_encode(""));

            return $this->successResponse(EmployeeResource::collection($employees), 'The record was showed success', 200);
        } catch (\Throwable $exception) {

            LogActivity::addToLog('The record could not be showed', 'false', 'ShowAllEmployees', json_encode(""), $exception->getMessage());
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
    public function store(StoreEmployeeRequest $request)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['created_by' => Auth::user()->id]);

            Employee::create($request->all());

            DB::commit();

            LogActivity::addToLog('The record was saved success', 'true', 'StoreEmployee', json_encode($request->all()));
            return $this->successResponse([], 'The record was saved success', 200);
        } catch (\Throwable $exception) {
            DB::rollBack();

            LogActivity::addToLog('The record could not be saved', 'false', 'StoreEmployee', json_encode($request->all()), $exception->getMessage());
            return $this->errorResponse('The record could not be saved', $exception->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        try {
            DB::beginTransaction();

            $society = Employee::find($employee->id);

            DB::commit();

            LogActivity::addToLog('The record was showed success', 'true', 'ShowOneEmployee', json_encode(""));
            return $this->successResponse(EmployeeResource::make($society), 'The record was showed success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be showed', 'false', 'ShowOneEmployee', json_encode(""), $exception->getMessage());
            return $this->errorResponse('The record could not be showed', $exception->getMessage(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        try {
            DB::beginTransaction();

            $request->request->add(['updated_by' => Auth::user()->id]);
            $employee->update($request->all());

            DB::commit();

            LogActivity::addToLog('The record was updated success', 'true', 'UpdateEmployee', "");

            return $this->successResponse([], 'The record was updated success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be updated', 'false', 'UpdateEmployee', '', $exception->getMessage());
            return $this->errorResponse('The record could not be updated', $exception->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        try {
            DB::beginTransaction();

            $employee->delete();

            DB::commit();

            LogActivity::addToLog('The record was deleted success', 'true', 'DeleteEmployee', '');
            return $this->successResponse([], 'The record was deleted success', 200);
        } catch (\Throwable $exception) {

            DB::rollBack();

            LogActivity::addToLog('The record could not be deleted', 'false', 'DeleteEmployee', '', $exception->getMessage());
            return $this->errorResponse('The record could not be deleted', $exception->getMessage(), 422);
        }
    }
}
