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

namespace App\Domain;

use App\Domain\Common\Helpers\Hateoas\HateoasBuilder;
use App\Domain\Common\Helpers\Hateoas\Links\AbstractLink;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AbstractSerializerNormalizer
 */
abstract class AbstractSerializerNormalizer
{
    /** @var HateoasBuilder */
    protected $hateoasBuilder;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /**
     * AbstractSerializerNormalizer constructor.
     *
     * @param HateoasBuilder                $hateoasBuilder
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        HateoasBuilder $hateoasBuilder,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->hateoasBuilder = $hateoasBuilder;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param array       $config
     * @param string|null $identifier
     *
     * @return array
     */
    protected function buildLinks(array $config, string $identifier = null)
    {
        $links = [];

        foreach ($config as $type => $values) {
            if (array_key_exists('secure', $config[$type]) &&
                !$this->authorizationChecker->isGranted($values['secure'])
            ) {
                continue;
            }
            $linkObject = $this->hateoasBuilder->build(
                $type,
                $values['route'],
                array_key_exists('params', $config[$type]) ?
                    [$values['params'] => $identifier] : []
            );
            $links[] = $this->linkObjectToArray($linkObject);
        }

        return $links;
    }

    private function linkObjectToArray(AbstractLink $linkObject)
    {
        return [
            'type' => $linkObject->getType(),
            'method' => $linkObject->getMethod(),
            'url' => $linkObject->getUrl(),
        ];
    }
}
