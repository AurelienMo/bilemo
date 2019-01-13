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

/**
 * Class PhoneHasFeature
 */
class PhoneHasFeature extends AbstractModel
{
    /** @var Phone */
    protected $phone;

    /** @var FeaturePhone */
    protected $featurePhone;

    /** @var string */
    protected $value;

    public function __construct(
        Phone $phone,
        FeaturePhone $featurePhone,
        string $value
    ) {
        $this->phone = $phone;
        $this->featurePhone = $featurePhone;
        $this->value = $value;
        parent::__construct();
    }

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @return FeaturePhone
     */
    public function getFeaturePhone(): FeaturePhone
    {
        return $this->featurePhone;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
