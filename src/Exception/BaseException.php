<?php

namespace FiveSay\Laravel\Api\Exception;

use Exception;

/**
 * 基础异常类
 */
class BaseException extends Exception
{
    /**
     * @var int
     */
    protected $statusCode = 500;

    /**
     * @var int
     */
    protected $defaultMessage = '';

    /**
     * @param string  $message
     * @param int $statusCode
     */
    public function __construct($message = null, $statusCode = null)
    {
        if (! is_null($message)) {
            $this->defaultMessage = $message;
        }

        parent::__construct($this->defaultMessage);

        if (! is_null($statusCode)) {
            $this->setStatusCode($statusCode);
        }
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return int the status code
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
