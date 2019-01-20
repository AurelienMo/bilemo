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

use App\Domain\AbstractLoader;
use App\Domain\Common\Helpers\ListRoles;
use App\Domain\InputInterface;
use App\Entity\Phone;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    const SERIALIZATION_CONTEXT = 'show_phone';
    const HATEOAS_BUILDER_CONFIGURATION = [
        'list' => [
            'method' => 'GET',
            'route' => 'list_phones',
        ],
        'delete' => [
            'method' => 'DELETE',
            'route' => 'delete_phone',
            'params' => 'id',
            'secure' => ListRoles::ROLE_COLLABORATOR,
        ],
    ];

    public function load(?InputInterface $input = null): ?string
    {
        $datas = $this->serializer->serialize($input->getPhonesFeatures(), 'json');
        return $this->sendDatasFormatted(
            $input->getPhone(),
            [
                'groups' => self::SERIALIZATION_CONTEXT,
                'features' => json_decode($datas),
            ]
        );
    }

    protected function getClassName(): string
    {
        return Phone::class;
    }
}
