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

namespace App\Domain\Common\Helpers\Hateoas;

use App\Domain\Common\Builders\LinkBuilder;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class HateoasBuilder
 */
class HateoasBuilder
{
    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /**
     * HateoasBuilder constructor.
     *
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->urlGenerator = $urlGenerator;
    }

    public function build(
        string $type,
        string $route,
        array $params = []
    ) {
        return LinkBuilder::build(
            $type,
            $this->urlGenerator->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_URL)
        );
    }
}
