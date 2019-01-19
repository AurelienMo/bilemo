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

namespace App\Entity;

use App\Entity\Traits\NameTrait;

/**
 * Class PhoneOs
 */
class PhoneOs extends AbstractModel
{
    use NameTrait;

    /** @var string */
    protected $shortName;

    /**
     * PhoneOs constructor.
     *
     * @param string $name
     * @param string $shortName
     *
     * @throws \Exception
     */
    public function __construct(
        string $name,
        string $shortName
    ) {
        $this->name = $name;
        $this->shortName = $shortName;
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->shortName;
    }
}
