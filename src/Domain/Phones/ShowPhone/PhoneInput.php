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

namespace App\Domain\Phones\ShowPhone;

use App\Domain\InputInterface;
use App\Entity\Phone;
use App\Entity\PhoneHasFeature;

/**
 * Class PhoneInput
 */
class PhoneInput implements InputInterface
{
    /** @var Phone */
    protected $phone;

    /** @var PhoneHasFeature[] */
    protected $phonesFeatures;

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     */
    public function setPhone(Phone $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return PhoneHasFeature[]
     */
    public function getPhonesFeatures(): array
    {
        return $this->phonesFeatures;
    }

    /**
     * @param PhoneHasFeature[] $phonesFeatures
     */
    public function setPhonesFeatures(array $phonesFeatures): void
    {
        $this->phonesFeatures = $phonesFeatures;
    }
}
