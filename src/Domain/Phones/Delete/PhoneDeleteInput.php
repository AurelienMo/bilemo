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

namespace App\Domain\Phones\Delete;

use App\Domain\InputInterface;
use App\Entity\Phone;

/**
 * Class PhoneDeleteInput
 */
class PhoneDeleteInput implements InputInterface
{
    /** @var Phone */
    protected $phone;

    /**
     * @return Phone
     */
    public function getPhone(): Phone
    {
        return $this->phone;
    }

    /**
     * @param Phone $phone
     *
     * @return PhoneDeleteInput
     */
    public function setPhone(Phone $phone): PhoneDeleteInput
    {
        $this->phone = $phone;
        return $this;
    }
}
