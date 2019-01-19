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

namespace App\Actions\API\Phones;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowPhone
 */
class ShowPhone
{
    /**
     * @Route("/phones/{id}", name="show_one", methods={"GET"})
     */
    public function show()
    {
        throw new \Exception('Pending implement');
    }
}
