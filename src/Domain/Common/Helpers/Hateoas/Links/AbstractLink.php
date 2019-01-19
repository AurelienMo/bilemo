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

namespace App\Domain\Common\Helpers\Hateoas\Links;

/**
 * Class AbstractLink
 */
abstract class AbstractLink
{
    /** @var string */
    protected $type;

    /** @var string */
    protected $method;

    /** @var string */
    protected $url;

    /**
     * AbstractLink constructor.
     *
     * @param string $url
     */
    public function __construct(
        string $url
    ) {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }
}
