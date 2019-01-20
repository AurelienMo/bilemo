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

namespace App\Domain\Phones\ShowPhone;

use App\Entity\Phone;

/**
 * Class NormalizerDatas
 */
class NormalizerDatas
{
    public static function normalize(Phone $phone, array $features, array $links)
    {
        return [
            'id' => $phone->getId()->toString(),
            'name' => $phone->getName(),
            'description' => $phone->getDescription(),
            'os' => $phone->getPhoneOs()->getName(),
            'brand' => $phone->getBrand()->getName(),
            'memory' => sprintf('%sGo', $phone->getPhoneMemory()->getName()),
            'typeConnector' => $phone->getTypeConnector()->getName(),
            'features' => $features,
            '_links' => $links,
        ];
    }
}
