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

namespace App\UI\Actions\API\Clients;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GetOneClient
 */
class GetOneClient
{
    /**
     * @Route("/clients/{id}", name="show_client", methods={"GET"})
     *
     * @param Request $request
     *
     * @throws \Exception
     */
    public function getOne(Request $request)
    {
        throw new \Exception('Not implemented');
    }
}
