<?php


namespace App\Helpers;

use App\Models\LogActivity as ModelsLogActivity;
use Illuminate\Support\Facades\Request;

class LogActivity
{


    public static function addToLog($subject,$success = true,$endpoint = "",$requestValues = "",$message = "")
    {
    	$log = [];
    	$log['subject'] = $subject;
        $log['success'] = $success;
        $log['endpoint'] = $endpoint;
    	$log['method'] = Request::method();
        $log['url'] = Request::fullUrl();
    	$log['ip'] = Request::ip();
        $log['values'] = $requestValues;
        $log['message'] = $message;
    	$log['agent'] = Request::header('user-agent');
    	$log['user_id'] = auth()->check() ? auth()->user()->id : 1;

        try {

            ModelsLogActivity::create($log);

        } catch (\Throwable $exception) {

        }

    }


    public static function logActivityLists()
    {
    	return ModelsLogActivity::latest()->get();
    }


}
