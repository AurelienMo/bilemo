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

use App\Application\Helpers\Core\ProcessorErrorsHttp;
use App\Application\UseCases\AbstractRequestHandler;
use App\Application\UseCases\InputInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateClientRequestHandler
 */
class CreateClientRequestHandler extends AbstractRequestHandler
{
    public function handle(Request $request): InputInterface
    {
        $this->checkAuthorization('ROLE_COLLABORATOR', ProcessorErrorsHttp::CREATE_CLIENT_ACCESS);

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
