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

use App\Application\Helpers\Core\ErrorsBuilder;
use App\Common\Helpers\ProcessorErrorsHttp;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Entity\AbstractModel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractRequestHandler
 */
abstract class AbstractRequestHandler
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
     * AbstractRequestHandler constructor.
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
    public function handle(Request $request): InputInterface
    {
        $input = null;
        if ($this->havePayload()) {
            $input = $this->hydrateInputWithPayload($request);
        }

        if (\is_null($input)) {
            $input = $this->instanciateInputClass();
        }

        $this->validate($input);

        return $input;
    }

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
     * @return bool
     */
    protected function havePayload(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    abstract protected function getClassInput(): string;
}
