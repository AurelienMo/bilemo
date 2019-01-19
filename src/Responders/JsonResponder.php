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

namespace App\Responders;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class JsonResponder
 */
class JsonResponder
{
    public static function response(
        $datas = null,
        int $statusCode = Response::HTTP_OK,
        array $headers = [],
        bool $cacheable = false
    ) {
        $response = new Response(
            !is_null($datas) ? $datas : null,
            $statusCode,
            array_merge(
                [
                    'Content-Type' => 'application/json',
                ],
                $headers
            )
        );

        if ($cacheable) {
            $response
                ->setPublic()
                ->setSharedMaxAge(3600)
                ->setMaxAge(3600);
        }

        return $response;
    }
}
