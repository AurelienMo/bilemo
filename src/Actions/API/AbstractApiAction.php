<?php

declare(strict_types=1);

/*
 * This file is part of Bilemo
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Actions\API;

use App\Responders\JsonResponder;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractApiAction
 */
abstract class AbstractApiAction
{
    /** @var JsonResponder */
    protected $responder;

    /**
     * AbstractApiAction constructor.
     *
     * @param JsonResponder $responder
     */
    public function __construct(
        JsonResponder $responder
    ) {
        $this->responder = $responder;
    }

    /**
     * @param null  $datas
     * @param int   $statusCode
     * @param array $headers
     * @param bool  $cacheable
     *
     * @return Response
     */
    public function sendResponse(
        $datas = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        bool $cacheable = false
    ) {
        return JsonResponder::response($datas, $statusCode, $headers, $cacheable);
    }

    protected function getCache()
    {
        return new FilesystemCache();
    }
}
