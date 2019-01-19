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

namespace App\Domain\Common\Builders;

use App\Entity\Collaborator;

/**
 * Class CollaboratorBuilder
 */
class CollaboratorBuilder
{
    /**
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $role
     *
     * @return Collaborator
     *
     * @throws \Exception
     */
    public static function create(
        string $username,
        string $password,
        string $email,
        ?string $role
    ) {
        return new Collaborator(
            $username,
            $password,
            $email,
            $role
        );
    }
}
