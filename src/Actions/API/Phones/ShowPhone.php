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
use App\Domain\Phones\ShowPhone\Loader;
use App\Domain\Phones\ShowPhone\RequestResolver;
use App\Responders\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ShowPhone
 */
class ShowPhone extends AbstractApiAction
{
    /** @var RequestResolver */
    protected $resolver;

    /** @var Loader */
    protected $loader;

    /**
     * ShowPhone constructor.
     *
     * @param JsonResponder   $responder
     * @param RequestResolver $resolver
     * @param Loader          $loader
     */
    public function __construct(
        JsonResponder $responder,
        RequestResolver $resolver,
        Loader $loader
    ) {
        $this->resolver = $resolver;
        $this->loader = $loader;
        parent::__construct($responder);
    }

    /**
     * Show detail for a given phone
     *
     * @Route("/phones/{id}", name="show_one", methods={"GET"})
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
     *     description="Phone id targeted",
     *     required=true
     * )
     * @SWG\Response(
     *     response="200",
     *     description="Successfull obtain phone detail",
     *     ref="#/definitions/PhoneDetailOutput"
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized. Please login",
     *     @SWG\Schema(
     *         ref="#/definitions/JwtErrorOutput"
     * )
     * )
     * @SWG\Response(
     *     response="404",
     *     description="Phone not found",
     *     @SWG\Schema(
     *         ref="#/definitions/HttpErrorOutput"
     * )
     * )
     * @SWG\Tag(name="Phone")
     * @Security(name="Bearer")
     */
    public function show(Request $request)
    {
        $input = $this->resolver->resolve($request);
        $datas = $this->loader->load($input);

        return $this->sendResponse(
            $datas,
            Response::HTTP_OK,
            [],
            true
        );
    }
}
