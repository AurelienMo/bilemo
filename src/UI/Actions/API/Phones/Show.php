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

use App\UI\Actions\API\AbstractApiAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Show
 */
class Show extends AbstractApiAction
{
    /**
     * Display phone detail information
     *
     * @Route("/phones/{id}", name="show_detail_phone", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function show(Request $request)
    {
        $input = $this->requestHandler->handle($request);
        $output = $this->loader->load($input);

        return $this->sendResponse(null, Response::HTTP_OK, [], true);
    }
}
