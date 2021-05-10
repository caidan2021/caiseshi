<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     */
    public function report(Exception $exception)
    {
        if ($exception instanceof LogicException) {
            \Log::warning("逻辑问题：" . $exception->getMessage(), [
                'path' => request()->path(),
                'user_id' => \Auth::user() ? \Auth::user()->id : null,
                'input' => (new Request())->all(),
            ]);

            return '';
        } elseif ($exception instanceof ValidationException) {
            \Log::warning("Validation Exception", array_merge($exception->errors(), ['input' => request()->all()]));
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
