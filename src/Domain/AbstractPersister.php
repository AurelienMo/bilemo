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

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AbstractPersister
 */
abstract class AbstractPersister
{
    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var UrlGeneratorInterface */
    protected $urlGenerator;

    /**
     * AbstractPersister constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface  $urlGenerator
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param InputInterface $input
     *
     * @return OutputInterface|null
     */
    abstract public function save(InputInterface $input): ?OutputInterface;

    /**
     * @return string
     */
    abstract protected function getClassRepository(): string;

    /**
     * @param string|null $class
     *
     * @return ObjectRepository
     */
    protected function getRepository(?string $class = null): ObjectRepository
    {
        return $this->entityManager->getRepository(
            is_null($class) ? $this->getClassRepository() : $class
        );
    }
}
