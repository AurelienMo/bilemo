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

namespace App\Application\Helpers\Core;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ProcessorErrorsHttp
 */
class ProcessorErrorsHttp
{
    const FORBIDDEN_REMOVE_PHONE = 'Vous n\'êtes pas autorisé à supprimer ce produit.';
    const PRODUCT_NOT_FOUND = 'Ce produit n\'existe pas.';
    const CREATE_CLIENT_ACCESS = 'Vous devez faire partis de la société Bilemo pour créer des comptes clients.';
    const INTERNAL_ERROR_SERVER = 'Une erreur a été rencontré. Merci de réessayer plus tard.';

    public static function throwNotFound(string $message)
    {
        throw new HttpException(
            Response::HTTP_NOT_FOUND,
            $message
        );
    }

    public static function throwAccessDenied(string $message)
    {
        throw new HttpException(
            Response::HTTP_FORBIDDEN,
            $message
        );
    }

    public static function throwInternalError(string $message)
    {
        throw new HttpException(
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $message
        );
    }
}
