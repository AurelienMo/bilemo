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

namespace App\Application\UseCases\Phones\Delete;

use App\Application\Helpers\Core\ProcessorErrorsHttp;
use App\Application\UseCases\AbstractRequestHandler;
use App\Application\UseCases\InputInterface;
use App\Domain\Model\Phone;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestHandler
 */
class RequestHandler extends AbstractRequestHandler
{
    /**
     * @param Request $request
     *
     * @return InputInterface
     *
     * @throws NonUniqueResultException
     * @throws \ReflectionException
     */
    public function handle(Request $request): InputInterface
    {
        $this->checkAuthorization(
            'ROLE_COLLABORATOR',
            ProcessorErrorsHttp::FORBIDDEN_REMOVE_PHONE
        );

        $phone = $this->entityManager->getRepository(Phone::class)
                                     ->phoneExist((string) $request->attributes->get('id'));

        if (is_null($phone)) {
            ProcessorErrorsHttp::throwNotFound(ProcessorErrorsHttp::PRODUCT_NOT_FOUND);
        }

        $input = $this->instanciateInputClass();
        $input->setPhone($phone);

        return $input;
    }

    protected function getClassInput(): string
    {
        return DeletePhoneInput::class;
    }
}
