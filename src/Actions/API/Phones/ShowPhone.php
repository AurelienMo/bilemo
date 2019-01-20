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
use App\Domain\Phones\ShowPhone\Loader;
use App\Domain\Phones\ShowPhone\RequestResolver;
use App\Responders\JsonResponder;
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
     * @Route("/phones/{id}", name="show_one", methods={"GET"})
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
