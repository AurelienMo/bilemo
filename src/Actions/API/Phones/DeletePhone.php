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

namespace App\Actions\API\Phones;

use App\Actions\API\AbstractApiAction;
use App\Domain\Common\Exceptions\ValidatorException;
use App\Domain\Phones\Delete\Persister;
use App\Domain\Phones\Delete\RequestResolver;
use App\Responders\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeletePhone
 */
class DeletePhone extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $resolver;

    /** @var Persister */
    protected $persister;

    /**
     * DeletePhone constructor.
     *
     * @param JsonResponder   $responder
     * @param RequestResolver $resolver
     * @param Persister       $persister
     */
    public function __construct(
        JsonResponder $responder,
        RequestResolver $resolver,
        Persister $persister
    ) {
        $this->resolver = $resolver;
        $this->persister = $persister;
        parent::__construct($responder);
    }

    /**
     * Remove phone from catalog. Allowed only for BileMo collaborator
     *
     * @Route("/phones/{id}", name="delete_phone", methods={"DELETE"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws ValidatorException
     * @throws \ReflectionException
     *
     * @SWG\Parameter(
     *     in="path",
     *     name="id",
     *     type="string",
     *     required=true,
     *     description="Unique identifier targeted to remove phone"
     * )
     * @SWG\Response(
     *     response="204",
     *     description="Successful delete, no content."
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     @SWG\Schema(
     *     ref="#/definitions/JwtErrorOutput"
     * )
     * )
     * @SWG\Response(
     *     response="403",
     *     description="Forbidden. You are not allowed to access this ressource",
     *     @SWG\Schema(
     *     ref="#/definitions/HttpErrorOutput"
     * )
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Phone not found.",
     *     @SWG\Schema(
     *     ref="#/definitions/HttpErrorOutput"
     * )
     * )
     * @SWG\Tag(name="Phone")
     * @Security(name="Bearer")
     */
    public function delete(Request $request)
    {
        $input = $this->resolver->resolve($request);
        $this->persister->save($input);

        return $this->sendResponse(null, Response::HTTP_NO_CONTENT);
    }
}
