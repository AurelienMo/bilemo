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

namespace App\Application\UseCases\Phones\Detail;

use App\Application\UseCases\AbstractRequestHandler;
use App\Application\UseCases\InputInterface;
use App\Domain\Model\Phone;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class DetailPhoneRequestHandler
 */
class DetailPhoneRequestHandler extends AbstractRequestHandler
{
    public function handle(Request $request): InputInterface
    {
        $phoneDetail = $this->entityManager->getRepository(Phone::class)
                                     ->loadById((string) $request->attributes->get('id'));

        if (empty($phoneDetail)) {
            throw new HttpException(
                Response::HTTP_NOT_FOUND,
                'Ce produit n\'existe pas.'
            );
        }

        $input = $this->instanciateInputClass();
        $input->setPhone($phoneDetail[0]);
        unset($phoneDetail[0]);
        $input->setOptions(array_values($phoneDetail));

        return $input;
    }

    protected function getClassInput(): string
    {
        return DetailPhoneInput::class;
    }
}
