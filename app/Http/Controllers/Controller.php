<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = [];
    protected $errors = [];
    protected $errorsCode = [];
    protected $errorData = [];

    public function __construct()
    {
        $this->data['data'] = [];
    }

    public function validation($rules, $obj = null, $request = null)
    {
        try
        {
            if(!$obj) $obj = new \stdClass();
            if(!$request) $request = Request::all();
            Validator::make($request, $rules)->validate();

            foreach($rules as $k=>$value)
            {
                $value = isset($request[$k]) ? $request[$k] : null;
                if(is_array($obj) && $value !== null) $obj[$k] = $value;
                else if($value !== null) $obj->{$k} = $value;
            }
        }
        catch (\Illuminate\Validation\ValidationException $ex)
        {
            foreach($ex->validator->errors()->getMessages() as $k=>$message)
            {
                $this->errors[] = $message[0];
            }
            return $obj;
        }

        return $obj;
    }

    /**
     * @param array $data
     * @param int $errorCode
     * @param bool $noData
     * @param bool $noError
     * @return \Illuminate\Http\JsonResponse|string
     */
    protected function outPut(array $data = [], $errorCode = 200, $noData = false, $noError = false)
    {
        if(!isset($this->data['data'])) $this->data['data'] = [];

        if(count($data) > 0 || count($this->data['data']) > 0) $this->data['data'] = array_merge($this->data['data'], $data);
        $this->data['error'] = false;

        if($noData && count($this->errors) == 0)
        {
            $this->data = $this->data['data'];
            if(!$noError) $this->data['error'] = false;
        }

        return response()->json(count($this->errors) > 0 ? (object) [
            "error" => true,
            "message" => implode("\n", $this->errors),
            "messages_array" => $this->errors,
            "errorData" => $this->errorData,
            "errorsCode" => $this->errorsCode,
        ] : $this->data, count($this->errors) > 0 ? $errorCode : 200);
    }
}
