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

use App\Application\UseCases\Phones\ListPhones\Loader;
use App\UI\Actions\API\AbstractApiAction;
use App\UI\Responders\JsonResponder;
use Nelmio\ApiDocBundle\Annotation\Security;
use Psr\Cache\CacheItemPoolInterface;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListPhones
 */
class ListPhones extends AbstractApiAction
{
    /** @var Loader */
    protected $loader;

    /** @var CacheItemPoolInterface */
    protected $cache;

    public function __construct(
        JsonResponder $responder,
        Loader $loader,
        CacheItemPoolInterface $cache
    ) {
        $this->loader = $loader;
        $this->cache = $cache;
        parent::__construct($responder);
    }

    /**
     * List phones from BileMo
     *
     * @Route("/phones", name="list_phones", methods={"GET"})
     *
     * @return Response
     *
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @SWG\Response(
     *     response="200",
     *     description="List BileMo phone.",
     *     @SWG\Schema(
     *         ref="#/definitions/ListPhoneOutput"
     * )
     * )
     * @SWG\Response(
     *     response="401",
     *     description="Unauthorized, please login.",
     *     @SWG\Schema(
     *         ref="#/definitions/JwtErrorOutput"
     * )
     * )
     * @SWG\Tag(name="Phone")
     * @Security(name="Bearer")
     */
    public function listPhones(): Response
    {
        $output = $this->loader->load();

        return $this->sendResponse(
            $output->getItems(),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
