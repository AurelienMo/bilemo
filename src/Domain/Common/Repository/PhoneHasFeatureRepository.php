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

/**
 * Class PhoneHasFeatureRepository
 */
class PhoneHasFeatureRepository extends EntityRepository
{
    public function replacePhoneUuid(string $phoneId, string $newUuid)
    {
        $sql = <<<SQL
UPDATE amo_phone_has_feature SET amo_phone_id = '{$newUuid}' WHERE amo_phone_id = '{$phoneId}'
SQL;
        $stmt = $this->_em->getConnection()->prepare($sql);
        $stmt->execute();
    }
}
