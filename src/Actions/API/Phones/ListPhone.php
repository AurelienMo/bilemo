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
use App\Domain\Phones\ListPhones\Loader;
use App\Responders\JsonResponder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListPhone
 */
class ListPhone extends AbstractApiAction
{
    /** @var Loader */
    protected $loader;

    /**
     * ListPhone constructor.
     *
     * @param JsonResponder $responder
     * @param Loader        $loader
     */
    public function __construct(
        JsonResponder $responder,
        Loader $loader
    ) {
        $this->loader = $loader;
        parent::__construct($responder);
    }

    /**
     * List all phones
     *
     * @Route("/phones", name="list_phones", methods={"GET"})
     *
     * @return Response
     */
    public function listPhones()
    {
        $datas = $this->loader->load();

        return $this->sendResponse(
            $datas,
            Response::HTTP_OK,
            [],
            true
        );
    }
}
