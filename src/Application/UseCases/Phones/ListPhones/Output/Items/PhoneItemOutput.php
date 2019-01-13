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

use App\Application\Helpers\Hateoas\Links\AbstractLink;
use App\Application\UseCases\Output\Hateoas\Embed\ItemDefinitionEmbedInterface;
use App\Application\UseCases\OutputInterface;

/**
 * Class PhoneItemOutput
 */
class PhoneItemOutput implements OutputInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $os;

    /** @var string */
    protected $memory;

    /** @var ItemDefinitionEmbedInterface[] */
    protected $embed;

    /** @var AbstractLink[] */
    protected $links;

    /**
     * PhoneItemOutput constructor.
     *
     * @param string $id
     * @param string $name
     * @param string $os
     * @param string $memory
     * @param array  $embed
     * @param array  $links
     */
    public function __construct(
        string $id,
        string $name,
        string $os,
        string $memory,
        array $embed,
        array $links
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->os = $os;
        $this->memory = $memory;
        $this->embed = $embed;
        $this->links = $links;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }

    /**
     * @return string
     */
    public function getMemory(): string
    {
        return sprintf('%s Go', $this->memory);
    }

    /**
     * @return ItemDefinitionEmbedInterface[]
     */
    public function getEmbed(): array
    {
        return $this->embed;
    }

    /**
     * @return AbstractLink[]
     */
    public function getLinks(): array
    {
        return $this->links;
    }
}
