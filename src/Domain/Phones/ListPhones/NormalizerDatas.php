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

namespace App\Domain\Phones\ListPhones;

use App\Entity\Phone;

/**
 * Class NormalizerDatas
 */
class NormalizerDatas
{
    public static function normalizeDatas(Phone $phone, array $links)
    {
        return [
            'id' => $phone->getId()->toString(),
            'name' => $phone->getName(),
            'brand' => $phone->getBrand()->getName(),
            'os' => $phone->getPhoneOs()->getName(),
            'memory' => $phone->getPhoneMemory()->getName(),
            '_links' => $links,
        ];
    }
}
