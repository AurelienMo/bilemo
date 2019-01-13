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

/**
 * Class OptionOutput
 */
class OptionOutput
{
    /** @var string */
    protected $name;

    /** @var string */
    protected $value;

    /**
     * OptionOutput constructor.
     *
     * @param string $name
     * @param string $value
     */
    public function __construct(
        string $name,
        string $value
    ) {
        $this->name = $name;
        $this->value = $value;
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
    public function getValue(): string
    {
        return $this->value;
    }
}
