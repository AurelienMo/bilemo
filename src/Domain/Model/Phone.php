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

namespace App\Domain\Model;

use App\Domain\Model\Traits\NameTrait;

/**
 * Class Phone
 */
class Phone extends AbstractModel
{
    use NameTrait;

    /** @var string */
    protected $description;

    /** @var Brand */
    protected $brand;

    /** @var PhoneMemory */
    protected $phoneMemory;

    /** @var PhoneOs */
    protected $phoneOs;

    /** @var TypeConnector */
    protected $typeConnector;

    public function __construct(
        string $name,
        string $description,
        Brand $brand,
        PhoneMemory $phoneMemory,
        PhoneOs $phoneOs,
        TypeConnector $typeConnector
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->brand = $brand;
        $this->phoneMemory = $phoneMemory;
        $this->phoneOs = $phoneOs;
        $this->typeConnector = $typeConnector;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return Brand
     */
    public function getBrand(): Brand
    {
        return $this->brand;
    }

    /**
     * @return PhoneMemory
     */
    public function getPhoneMemory(): PhoneMemory
    {
        return $this->phoneMemory;
    }

    /**
     * @return PhoneOs
     */
    public function getPhoneOs(): PhoneOs
    {
        return $this->phoneOs;
    }

    /**
     * @return TypeConnector
     */
    public function getTypeConnector(): TypeConnector
    {
        return $this->typeConnector;
    }
}
