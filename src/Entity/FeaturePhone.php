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
 * Class FeaturePhone
 */
class FeaturePhone extends AbstractModel
{
    use NameTrait;

    /** @var string|null */
    protected $typeValue;

    public function __construct(
        string $name,
        ?string $typeValue = null
    ) {
        $this->name = $name;
        $this->typeValue = $typeValue;
        parent::__construct();
    }

    /**
     * @return string|null
     */
    public function getTypeValue(): ?string
    {
        return $this->typeValue;
    }
}
