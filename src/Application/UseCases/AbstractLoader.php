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

namespace App\Application\UseCases;

use App\Application\Helpers\Hateoas\HateoasBuilder;
use App\Application\UseCases\Phones\ListPhones\Output\ListPhoneOutput;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

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

    /**
     * AbstractLoader constructor.
     *
     * @param EntityManagerInterface        $entityManager
     * @param HateoasBuilder                $hateoasBuilder
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        HateoasBuilder $hateoasBuilder,
        AuthorizationCheckerInterface $authorizationChecker
    ) {
        $this->entityManager = $entityManager;
        $this->hateoasBuilder = $hateoasBuilder;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param InputInterface|null $input
     *
     * @return OutputInterface|null
     */
    public function load(?InputInterface $input = null): ?OutputInterface
    {
        $datas = $this->obtainDatasFromDatabase($input);

        return $this->buildOutput($datas);
    }

    /**
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->entityManager->getRepository($this->getClassName());
    }

    /**
     * @param InputInterface|null $input
     *
     * @return mixed
     */
    abstract protected function obtainDatasFromDatabase(?InputInterface $input);

    /**
     * Return class name to get Repository related
     *
     * @return string
     */
    abstract protected function getClassName(): string;

    /**
     * Build output with given datas
     *
     * @param $datas
     *
     * @return mixed
     */
    abstract protected function buildOutput($datas): ?OutputInterface;
}
