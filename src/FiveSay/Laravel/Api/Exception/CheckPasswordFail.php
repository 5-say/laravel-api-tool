<?php

namespace FiveSay\Laravel\Api\Exception;

/**
 * 异常：密码校验失败
 */
class CheckPasswordFail extends BaseException
{
    /**
     * @var int
     */
    protected $statusCode = 422;

    /**
     * @var int
     */
    protected $defaultMessage = '密码错误';
}
