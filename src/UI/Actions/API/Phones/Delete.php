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

use App\UI\Actions\API\AbstractApiAction;
use Behat\Behat\Tester\Exception\PendingException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Delete
 */
class Delete extends AbstractApiAction
{
    /**
     * @Route("/phones/{id}", name="delete_phone", methods={"DELETE"})
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        throw new PendingException('Not implement yet');
    }
}
