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
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Class AbstractLoader
 */
abstract class AbstractLoader
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var HateoasBuilder */
    protected $hateoasBuilder;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * AbstractLoader constructor.
     *
     * @param EntityManagerInterface        $entityManager
     * @param HateoasBuilder                $hateoasBuilder
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param SerializerInterface           $serializer
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        HateoasBuilder $hateoasBuilder,
        AuthorizationCheckerInterface $authorizationChecker,
        SerializerInterface $serializer
    ) {
        $this->entityManager = $entityManager;
        $this->hateoasBuilder = $hateoasBuilder;
        $this->authorizationChecker = $authorizationChecker;
        $this->serializer = $serializer;
    }

    /**
     * @param null  $datas
     * @param array $context
     *
     * @return string
     */
    public function sendDatasFormatted($datas = null, array $context = [])
    {
        return $this->serializer->serialize(
            $datas,
            'json',
            $context
        );
    }

    /**
     * @param InputInterface|null $input
     *
     * @return string|null
     */
    abstract public function load(?InputInterface $input = null): ?string;

    /**
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository($this->getClassName());
    }

    /**
     * Return class name to get Repository related
     *
     * @return string
     */
    abstract protected function getClassName(): string;
}
