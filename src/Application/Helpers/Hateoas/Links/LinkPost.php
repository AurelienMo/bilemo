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

namespace App\Application\Helpers\Hateoas\Links;

/**
 * Class LinkPost
 */
class LinkPost extends AbstractLink
{
    protected $type = 'new';

    protected $method = 'POST';
}