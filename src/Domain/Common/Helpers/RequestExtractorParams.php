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

namespace App\Domain\Common\Helpers;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestExtractorParams
 */
final class RequestExtractorParams
{
    const QUERY_PARAMS = 'query';
    const PATH_PARAMS = 'path';

    /**
     * @param Request $request
     * @param string  $type
     * @param string  $name
     *
     * @return mixed|null
     */
    public static function extractParams(Request $request, string $type, string $name)
    {
        $value = null;
        switch ($type) {
            case self::QUERY_PARAMS:
                $value = $request->query->get($name) ?? null;
                break;
            case self::PATH_PARAMS:
                $value = $request->attributes->get($name) ?? null;
                break;
        }

        return $value;
    }
}
