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

namespace App\UI\Actions\API\Clients;

use App\Application\Exceptions\ValidatorException;
use App\Application\UseCases\Clients\Create\CreateClientPersister;
use App\Application\UseCases\Clients\Create\CreateClientRequestHandler;
use App\UI\Actions\API\AbstractApiAction;
use App\UI\Responders\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CreateClient
 */
class CreateClient extends AbstractApiAction
{
    /** @var CreateClientRequestHandler */
    private $requestHandler;

    /** @var CreateClientPersister */
    private $persister;

    public function __construct(
        JsonResponder $responder,
        CreateClientRequestHandler $requestHandler,
        CreateClientPersister $persister
    ) {
        $this->requestHandler = $requestHandler;
        $this->persister = $persister;
        parent::__construct($responder);
    }

    /**
     * Create a client with collaborator account
     *
     * @Route("/clients", name="create_client", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidatorException
     * @throws \ReflectionException
     * @throws \Exception
     *
     * @SWG\Parameter(
     *     in="body",
     *     name="body",
     *     description="Datas client to create client to database",
     *     required=true,
     *     @SWG\Schema(ref="#/definitions/CreateClientInput")
     * )
     * @SWG\Response(
     *     response="201",
     *     description="Successful create client"
     * )
     * @SWG\Response(
     *     response="400",
     *     description="Invalid request. Check your request."
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please connect to your account."
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Forbidden. You are not allowed to access this resource."
     * )
     * @SWG\Tag(name="Client")
     * @Security(name="Bearer")
     */
    public function create(Request $request)
    {
        $input = $this->requestHandler->handle($request);
        $output = $this->persister->save($input);

        return $this->sendResponse(null, Response::HTTP_CREATED, ['Location' => $output->getLocation()]);
    }
}
