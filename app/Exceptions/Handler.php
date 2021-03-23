<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        DB::rollback();
        $rendered = parent::render($request, $e);
        $msg = $this->getFixedMessage($e);
        $response = [
            'code' => $rendered->getStatusCode()
        ];
        if( gettype( $msg )== "string" ){
            $response['errors'] = [ $msg ];
        }else{
            $response =  array_merge($response, (array)$msg);
        }
        return response()->json( $response, $rendered->getStatusCode());
    }
    private function getFixedMessage($e){
        if( $this->isJson($e->getMessage()) ){
            return json_decode( $e->getMessage() );
        }
        $fileName = explode( (strpos($e->getFile(), "\\")!==false?"\\":"/"), $e->getFile());
        $stringMsg = $e->getMessage();
        $stringMsg = $stringMsg === null || $stringMsg == ""? "Maybe Server Error" : $stringMsg;
        $msg = $stringMsg.(env("APP_DEBUG",false)?" => file: ".str_replace(".php","",end($fileName))." line: ".$e->getLine():"");
        return $msg;
    }
    function isJson($args) {
        json_decode($args);
        return (json_last_error()===JSON_ERROR_NONE);
    }
}
