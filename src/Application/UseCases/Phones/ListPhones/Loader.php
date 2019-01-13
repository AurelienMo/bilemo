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

namespace App\Application\UseCases\Phones\ListPhones;

use App\Application\Helpers\Hateoas\Links\LinkBuilder;
use App\Application\UseCases\AbstractLoader;
use App\Application\UseCases\InputInterface;
use App\Application\UseCases\OutputInterface;
use App\Application\UseCases\Phones\ListPhones\Output\Items\BrandContentEmbed;
use App\Application\UseCases\Phones\ListPhones\Output\Items\BrandDefinitionEmbed;
use App\Application\UseCases\Phones\ListPhones\Output\Items\PhoneItemOutput;
use App\Application\UseCases\Phones\ListPhones\Output\ListPhoneOutput;
use App\Domain\Model\Brand;
use App\Domain\Model\Phone;

/**
 * Class Loader
 */
class Loader extends AbstractLoader
{
    protected function obtainDatasFromDatabase(?InputInterface $input)
    {
        return $this->getRepository()->listPhones();
    }

    protected function getClassName(): string
    {
        return Phone::class;
    }

    protected function buildOutput($datas): ?OutputInterface
    {
        $output = new ListPhoneOutput();
        /** @var Phone $phone */
        foreach ($datas as $phone) {
            $phoneOutput = new PhoneItemOutput(
                $phone->getId()->toString(),
                $phone->getName(),
                $phone->getPhoneOs()->getName(),
                $phone->getPhoneMemory()->getName(),
                $this->buildEmbed($phone->getBrand()),
                $this->buildLinksHateoas($phone)
            );

            $output->addPhone($phoneOutput);
        }

        return $output;
    }

    private function buildEmbed(Brand $brand)
    {
        $embeded = [];
        $embeded[] = new BrandDefinitionEmbed(
            new BrandContentEmbed($brand->getId()->toString(), $brand->getName())
        );

        return $embeded;
    }

    /**
     * @param Phone $phone
     *
     * @return array
     */
    private function buildLinksHateoas(Phone $phone)
    {
        $links = [];
        $links[] = $this->hateoasBuilder->build(
            LinkBuilder::SHOW_ONE,
            'show_detail_phone',
            ['id' => $phone->getId()->toString()]
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
