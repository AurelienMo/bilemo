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

use App\Domain\Model\PhoneHasFeature;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function loadById(string $identifier)
    {
        return $this->createQueryBuilder('p')
                    ->select('p', 'b', 'pm', 'po', 'tc')
                    ->innerJoin('p.brand', 'b', 'WITH', 'b.id = p.brand')
                    ->innerJoin('p.phoneMemory', 'pm', 'WITH', 'pm.id = p.phoneMemory')
                    ->innerJoin('p.phoneOs', 'po', 'WITH', 'po.id = p.phoneOs')
                    ->innerJoin('p.typeConnector', 'tc', 'WITH', 'tc.id = p.typeConnector')
                    ->addSelect('phf', 'fp')
                    ->from(PhoneHasFeature::class, 'phf')
                    ->innerJoin('phf.featurePhone', 'fp', 'WITH', 'fp.id = phf.featurePhone')
                    ->where('p.id = :id')
                    ->andWhere('phf.phone = :id')
                    ->setParameter('id', $identifier)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * @param string $identifier
     *
     * @return mixed
     *
     * @throws NonUniqueResultException
     */
    public function phoneExist(string $identifier)
    {
        return $this->createQueryBuilder('p')
                    ->where('p.id = :identifier')
                    ->setParameter('identifier', $identifier)
                    ->getQuery()
                    ->getOneOrNullResult();
    }
}
