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
use App\Entity\Phone;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Domain\Phones\ListPhones\Loader as LoaderListPhones;
use App\Domain\Phones\ListPhones\NormalizerDatas as NormalizerListPhones;
use App\Domain\Phones\ShowPhone\Loader as LoaderShowPhone;
use App\Domain\Phones\ShowPhone\NormalizerDatas as NormalizerShowPhone;

/**
 * Class PhoneNormalizer
 */
class PhoneNormalizer extends AbstractSerializerNormalizer implements NormalizerInterface
{
    const LIST_CONTEXT = [
        LoaderListPhones::SERIALIZATION_CONTEXT,
    ];

    public function normalize(
        $object,
        $format = null,
        array $context = array()
    ) {
        $datas = null;
        switch ($context['groups']) {
            case LoaderListPhones::SERIALIZATION_CONTEXT:
                $links = $this->buildLinks(
                    LoaderListPhones::HATEOAS_BUILDER_CONFIGURATION,
                    $object->getId()->toString()
                );
                $datas = NormalizerListPhones::normalizeDatas($object, $links);
                break;
            case LoaderShowPhone::SERIALIZATION_CONTEXT:
                $links = $this->buildLinks(
                    LoaderShowPhone::HATEOAS_BUILDER_CONFIGURATION,
                    $object->getId()->toString()
                );
                $datas = NormalizerShowPhone::normalize($object, $context['features'], $links);
        }

        return $datas;
    }

    public function supportsNormalization(
        $data,
        $format = null
    ) {
        return $data instanceof Phone;
    }
}
