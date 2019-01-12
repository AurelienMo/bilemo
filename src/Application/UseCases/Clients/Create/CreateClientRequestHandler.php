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

namespace App\Application\UseCases\Clients\Create;

use App\Application\UseCases\AbstractRequestHandler;
use App\Application\UseCases\InputInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CreateClientRequestHandler
 */
class CreateClientRequestHandler extends AbstractRequestHandler
{
    public function handle(Request $request): InputInterface
    {
        if (!$this->authorizationChecker->isGranted('ROLE_COLLABORATOR')) {
            throw new HttpException(
                Response::HTTP_FORBIDDEN,
                'Vous devez faire partis de la société Bilemo pour créer des comptes clients.'
            );
        }

        $input = $this->hydrateInputWithPayload($request);
        $this->validate($input);

        return $input;
    }

    /**
     * @return string
     */
    protected function getClassInput(): string
    {
        return CreateClientInput::class;
    }

    protected function havePayload(): bool
    {
        return true;
    }
}
