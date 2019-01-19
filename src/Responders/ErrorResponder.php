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
 * Class ErrorResponder
 */
class ErrorResponder
{
    /**
     * @param array $datas
     * @param int   $statusCode
     *
     * @return Response
     */
    public static function response($datas, int $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return new Response(
            $datas,
            $statusCode,
            [
                'Content-Type' => 'application/json',
            ]
        );
    }
}
