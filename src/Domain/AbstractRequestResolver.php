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

use App\Domain\Common\Builders\ErrorsBuilder;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Domain\Common\Helpers\ProcessorErrorsHttp;
use App\Entity\AbstractModel;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractRequestResolver
 */
abstract class AbstractRequestResolver
{
    /** @var SerializerInterface */
    protected $serializer;

    /** @var ValidatorInterface */
    protected $validator;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /** @var AuthorizationCheckerInterface */
    protected $authorizationChecker;

    /** @var EntityManagerInterface */
    protected $entityManager;

    /**
     * AbstractRequestResolver constructor.
     *
     * @param SerializerInterface           $serializer
     * @param ValidatorInterface            $validator
     * @param TokenStorageInterface         $tokenStorage
     * @param AuthorizationCheckerInterface $authorizationChecker
     * @param EntityManagerInterface        $entityManager
     */
    public function __construct(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        TokenStorageInterface $tokenStorage,
        AuthorizationCheckerInterface $authorizationChecker,
        EntityManagerInterface $entityManager
    ) {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->tokenStorage = $tokenStorage;
        $this->authorizationChecker = $authorizationChecker;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     *
     * @return InputInterface|object
     *
     * @throws \ReflectionException
     * @throws ValidatorException
     */
    abstract public function resolve(Request $request): InputInterface;

    /**
     * Validate input according different constraints
     *
     * @param InputInterface $input
     *
     * @throws ValidatorException
     */
    protected function validate(InputInterface $input)
    {
        $constraintList = $this->validator->validate($input);
        if (count($constraintList) > 0) {
            ErrorsBuilder::buildErrors($constraintList);
        }
    }

    protected function hydrateInputWithPayload(Request $request)
    {
        return $this->serializer->deserialize($request->getContent(), $this->getClassInput(), 'json');
    }

    /**
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function instanciateInputClass()
    {
        $reflectClass = new \ReflectionClass($this->getClassInput());
        $class = $reflectClass->name;
        return new $class();
    }

    /**
     * @param string        $attribute
     * @param AbstractModel $model
     * @param string        $errorMessage
     */
    protected function checkAuthorization(string $attribute, string $errorMessage, AbstractModel $model = null)
    {
        if (!$this->authorizationChecker->isGranted($attribute, $model)) {
            ProcessorErrorsHttp::throwAccessDenied($errorMessage);
        }
    }

    /**
     * @param string $className
     *
     * @return ObjectRepository
     */
    protected function getRepository(string $className)
    {
        return $this->entityManager->getRepository($className);
    }

    /**
     * @return string
     */
    abstract protected function getClassInput(): string;
}
