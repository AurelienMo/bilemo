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

namespace App\Application\UseCases\Phones\Detail\Output;

use App\Application\Helpers\Hateoas\Links\AbstractLink;
use App\Application\UseCases\Output\Hateoas\Embed\ItemDefinitionEmbedInterface;
use App\Application\UseCases\OutputInterface;

/**
 * Class PhoneOutput
 */
class PhoneOutput implements OutputInterface
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $brand;

    /** @var string */
    protected $memory;

    /** @var string */
    protected $os;

    /** @var string */
    protected $typeConnector;

    /** @var OptionOutput[] */
    protected $options;

    /** @var AbstractLink[] */
    protected $links;

    /**
     * PhoneOutput constructor.
     *
     * @param string                         $id
     * @param string                         $name
     * @param OptionOutput[]                 $options
     * @param ItemDefinitionEmbedInterface[] $embed
     * @param AbstractLink[]                 $links
     */
    public function __construct(
        string $id,
        string $name,
        string $brand,
        string $memory,
        string $os,
        string $typeConnector,
        array $options,
        array $links
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
        $this->memory = $memory;
        $this->os = $os;
        $this->typeConnector = $typeConnector;
        $this->options = $options;
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
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @return string
     */
    public function getMemory(): string
    {
        return sprintf('%s Go', $this->memory);
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
    public function getTypeConnector(): string
    {
        return $this->typeConnector;
    }

    /**
     * @return OptionOutput[]
     */
    public function getOptions(): ?array
    {
        return $this->options;
    }

    /**
     * @return AbstractLink[]
     */
    public function getLinks(): ?array
    {
        return $this->links;
    }
}
