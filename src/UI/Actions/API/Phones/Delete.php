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

namespace App\UI\Actions\API\Phones;

use App\Application\UseCases\Phones\Delete\Persister;
use App\Application\UseCases\Phones\Delete\RequestHandler;
use App\UI\Actions\API\AbstractApiAction;
use App\UI\Responders\JsonResponder;
use Behat\Behat\Tester\Exception\PendingException;
use Doctrine\ORM\NonUniqueResultException;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Delete
 */
class Delete extends AbstractApiAction
{
    /** @var RequestHandler */
    private $requestHandler;

    /** @var Persister */
    private $persister;

    public function __construct(
        JsonResponder $responder,
        RequestHandler $requestHandler,
        Persister $persister
    ) {
        $this->requestHandler = $requestHandler;
        $this->persister = $persister;
        parent::__construct($responder);
    }

    /**
     * Remove phone from database
     *
     * @Route("/phones/{id}", name="delete_phone", methods={"DELETE"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws NonUniqueResultException
     * @throws \ReflectionException
     *
     * @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     required=true,
     *     description="Unique identifier of phone"
     * )
     * @SWG\Response(
     *     response="204",
     *     description="Successful delete."
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     @SWG\Schema(
     *         ref="#/definitions/JwtErrorOutput"
     * )
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Forbidden. You are not allowed.",
     *     @SWG\Schema(
     *         ref="#/definitions/HTTPErrorOutput"
     * )
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Phone not found",
     *     @SWG\Schema(
     *         ref="#/definitions/HTTPErrorOutput"
     * )
     * )
     * @SWG\Tag(name="Phone")
     * @Security(name="Bearer")
     */
    public function delete(Request $request)
    {
        $input = $this->requestHandler->handle($request);
        $this->persister->save($input);

        return $this->sendResponse(null, Response::HTTP_NO_CONTENT);
    }
}
