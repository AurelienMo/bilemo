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
 * Class LinkBuilder
 */
class LinkBuilder
{
    const SHOW_ONE = 'self';
    const LIST = 'list';
    const DELETE = 'delete';
    const NEW = 'new';

    public static function build(string $type, string $url): AbstractLink
    {
        $link = null;
        switch ($type) {
            case self::SHOW_ONE:
                $link = new LinkGetOne($url);
                break;
            case self::LIST:
                $link = new LinkGetList($url);
                break;
            case self::DELETE:
                $link = new LinkDelete($url);
                break;
            case self::NEW:
                $link = new LinkPost($url);
                break;
        }

        return $link;
    }
}
