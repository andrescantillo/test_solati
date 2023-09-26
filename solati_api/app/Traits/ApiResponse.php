<?php

namespace App\Traits;

trait ApiResponse{

    protected function successResponse($data, $message = null, $code = 200, $aPagination = [])
	{
		return response([
			'status'=> 'Success',
			'message' => $message,
			'data' => $data,
			'pagination' => $aPagination,
			'errors' => null,
			'code' => $code
		])->setStatusCode($code);
	}

	protected function errorResponse($errorMessages, $errors = [], $code = 404, $trace = [])
	{
		return response()->json([
			'status'=>'Error',
			'message' => $errorMessages,
			'data' => null,
            'errors' => $errors,
            'code' => $code,
            'trace' => $trace
		], $code);
	}

}
