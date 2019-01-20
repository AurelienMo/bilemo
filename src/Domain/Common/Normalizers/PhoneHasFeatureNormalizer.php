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

namespace App\Domain\Common\Normalizers;

use App\Domain\AbstractSerializerNormalizer;
use App\Entity\PhoneHasFeature;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class PhoneHasFeatureNormalizer
 */
class PhoneHasFeatureNormalizer extends AbstractSerializerNormalizer implements NormalizerInterface
{
    /**
     * @param PhoneHasFeature $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize(
        $object,
        $format = null,
        array $context = array()
    ) {
        return [
            'id' => $object->getId()->toString(),
            'name' => $object->getFeaturePhone()->getName(),
            'value' => sprintf('%s%s', $object->getValue(), $object->getFeaturePhone()->getTypeValue())
        ];
    }

    public function supportsNormalization(
        $data,
        $format = null
    ) {
        return $data instanceof PhoneHasFeature;
    }
}
