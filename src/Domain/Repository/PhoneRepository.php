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

namespace App\Domain\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PhoneRepository
 */
class PhoneRepository extends EntityRepository
{
    public function listPhones()
    {
        $qb = $this->createQueryBuilder('p')
                   ->select('p', 'b', 'pm', 'po')
                   ->innerJoin('p.brand', 'b', 'WITH', 'b.id = p.brand')
                   ->innerJoin('p.phoneMemory', 'pm', 'WITH', 'pm.id = p.phoneMemory')
                   ->innerJoin('p.phoneOs', 'po', 'WITH', 'po.id = p.phoneOs')
                   ->getQuery();

        return $qb->getResult();
    }
}
