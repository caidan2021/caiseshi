<?php
/**
 * Created by IntelliJ IDEA.
 * Author: flashytime
 * Date: 2018/10/16 14:26
 */

namespace App\Exceptions;

use Throwable;

abstract class ApiException extends \Exception
{
    protected $headers = [];

    protected $statusCode;

    /**
     * ApiException constructor.
     * @param string $message
     * @param array $headers
     * @param Throwable|null $previous
     */
    public function __construct($message = '', array $headers = [], Throwable $previous = null)
    {
        $this->headers = $headers;

        parent::__construct($message, $this->statusCode, $previous);
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
