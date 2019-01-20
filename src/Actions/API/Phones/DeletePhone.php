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
 * Class DeletePhone
 */
class DeletePhone
{
    /**
     * @Route("/phones/{id}", name="delete_phone", methods={"DELETE"})
     */
    public function delete()
    {
    }
}
