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

namespace App\Application\UseCases\Phones\ListPhones\Output\Items;

use App\Application\UseCases\Output\Hateoas\Embed\ItemDefinitionEmbedInterface;

/**
 * Class BrandDefinitionEmbed
 */
class BrandDefinitionEmbed implements ItemDefinitionEmbedInterface
{
    /** @var BrandContentEmbed */
    protected $brand;

    /**
     * BrandDefinitionEmbed constructor.
     *
     * @param BrandContentEmbed $brand
     */
    public function __construct(
        BrandContentEmbed $brand
    ) {
        $this->brand = $brand;
    }

    /**
     * @return BrandContentEmbed
     */
    public function getBrand(): BrandContentEmbed
    {
        return $this->brand;
    }
}
