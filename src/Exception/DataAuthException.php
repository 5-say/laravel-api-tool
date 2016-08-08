<?php

namespace FiveSay\Laravel\Api\Exception;

/**
 * 异常：权限校验失败
 */
class DataAuthException extends BaseException
{
    /**
     * @var int
     */
    protected $statusCode = 403;

    /**
     * @var int
     */
    protected $defaultMessage = '未授权操作';
}
