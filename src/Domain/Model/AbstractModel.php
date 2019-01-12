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

use App\Domain\Model\Traits\IdTrait;
use App\Domain\Model\Traits\TimestampableTrait;
use Ramsey\Uuid\Uuid;

/**
 * Class AbstractModel
 */
abstract class AbstractModel
{
    use IdTrait;
    use TimestampableTrait;

    /**
     * AbstractModel constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    /**
     * @throws \Exception
     */
    public function onPersist()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * @throws \Exception
     */
    public function onUpdate()
    {
        $this->updatedAt = new \DateTime();
    }
}
