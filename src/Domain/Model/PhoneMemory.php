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
 * Class PhoneMemory
 */
class PhoneMemory extends AbstractModel
{
    use NameTrait;

    /**
     * PhoneMemory constructor.
     *
     * @param string $name
     *
     * @throws \Exception
     */
    public function __construct(
        string $name
    ) {
        $this->name = $name;
        parent::__construct();
    }
}
