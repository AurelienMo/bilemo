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

/**
 * Class BrandContentEmbed
 */
class BrandContentEmbed
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /**
     * BrandContentEmbed constructor.
     *
     * @param string $id
     * @param string $name
     */
    public function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
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
}
