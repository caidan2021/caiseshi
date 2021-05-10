<?php
/**
 * Created by IntelliJ IDEA.
 * Author: flashytime
 * Date: 2018/10/16 16:40
 */

namespace App\Exceptions;

class LogicException extends ApiException
{
    protected $statusCode = 409;
}
