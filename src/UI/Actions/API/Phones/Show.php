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

namespace App\UI\Actions\API\Phones;

use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Show
 */
class Show
{
    /**
     * @Route("/phones/{id}", name="show_detail_phone", methods={"GET"})
     *
     * @param Request $request
     */
    public function show(Request $request)
    {
        throw new PendingException('Waiting implement');
    }
}