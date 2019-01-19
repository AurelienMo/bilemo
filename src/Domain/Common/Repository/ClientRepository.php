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

namespace App\Domain\Common\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class ClientRepository
 */
class ClientRepository extends EntityRepository implements UserLoaderInterface
{
    /**
     * @param string $username
     *
     * @return mixed|UserInterface|null
     *
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('c')
                ->where('c.username = :username OR c.email = :username')
                ->setParameter('username', $username)
                ->getQuery()
                ->getOneOrNullResult();
    }
}
