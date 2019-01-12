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

namespace App\Application\UseCases\Output;

use App\Application\UseCases\OutputInterface;

/**
 * Class LocationOutput
 */
class LocationOutput implements OutputInterface
{
    /** @var string */
    protected $location;

    /**
     * LocationOutput constructor.
     *
     * @param string $location
     */
    public function __construct(
        string $location
    ) {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }
}
