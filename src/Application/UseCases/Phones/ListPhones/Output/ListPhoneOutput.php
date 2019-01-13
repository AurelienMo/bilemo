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

namespace App\Application\UseCases\Phones\ListPhones\Output;

use App\Application\UseCases\OutputInterface;
use App\Application\UseCases\Phones\ListPhones\Output\Items\PhoneItemOutput;

/**
 * Class ListPhoneOutput
 */
class ListPhoneOutput implements OutputInterface
{
    /** @var PhoneItemOutput[]|null */
    protected $items;

    /**
     * @return PhoneItemOutput[]
     */
    public function getItems(): ?array
    {
        return $this->items;
    }

    /**
     * @param PhoneItemOutput $phoneItemOutput
     */
    public function addPhone(PhoneItemOutput $phoneItemOutput)
    {
        $this->items[] = $phoneItemOutput;
    }
}
