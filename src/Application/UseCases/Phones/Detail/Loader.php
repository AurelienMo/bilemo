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

namespace App\Application\UseCases\Phones\Detail;

use App\Application\Helpers\Hateoas\Links\LinkBuilder;
use App\Application\UseCases\AbstractLoader;
use App\Application\UseCases\InputInterface;
use App\Application\UseCases\OutputInterface;
use App\Application\UseCases\Phones\Detail\Output\OptionOutput;
use App\Application\UseCases\Phones\Detail\Output\PhoneOutput;
use App\Domain\Model\Phone;
use App\Domain\Model\PhoneHasFeature;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    /**
     * @param InputInterface|DetailPhoneInput|null $input
     *
     * @return OutputInterface|mixed|null
     */
    protected function obtainDatasFromDatabase(?InputInterface $input)
    {
        return $input;
    }

    protected function getClassName(): string
    {
        return Phone::class;
    }

    /**
     * @param DetailPhoneInput $datas
     *
     * @return OutputInterface|null
     */
    protected function buildOutput($datas): ?OutputInterface
    {
        $phoneOutput = new PhoneOutput(
            $datas->getPhone()->getId()->toString(),
            $datas->getPhone()->getName(),
            $datas->getPhone()->getBrand()->getName(),
            $datas->getPhone()->getPhoneMemory()->getName(),
            $datas->getPhone()->getPhoneOs()->getName(),
            $datas->getPhone()->getTypeConnector()->getName(),
            $this->buildOptions($datas->getOptions()),
            $this->buildLinksHateoas($datas->getPhone())
        );

        return $phoneOutput;
    }

    private function buildOptions(array $options)
    {
        $results = [];
        /** @var PhoneHasFeature $option */
        foreach ($options as $option) {
            $results[] = new OptionOutput(
                $option->getFeaturePhone()->getName(),
                sprintf('%s%s', $option->getValue(), $option->getFeaturePhone()->getTypeValue() ?? '')
            );
        }

        return $results;
    }

    private function buildLinksHateoas(Phone $phone)
    {
        $links = [];
        $links[] = $this->hateoasBuilder->build(
            LinkBuilder::SHOW_ONE,
            'show_detail_phone',
            ['id' => $phone->getId()->toString()]
        );
        $links[] = $this->hateoasBuilder->build(
            LinkBuilder::LIST,
            'list_phones'
        );
        if ($this->authorizationChecker->isGranted('ROLE_COLLABORATOR')) {
            $links[] = $this->hateoasBuilder->build(
                LinkBuilder::DELETE,
                'delete_phone',
                ['id' => $phone->getId()->toString()]
            );
        }

        return $links;
    }
}
