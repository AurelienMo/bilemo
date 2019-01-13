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
use Doctrine\Common\Cache\RedisCache;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\TraceableAdapter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ListPhones
 */
class ListPhones extends AbstractApiAction
{
    /** @var Loader */
    protected $loader;

    /** @var AdapterInterface */
    protected $cache;

    public function __construct(
        JsonResponder $responder,
        Loader $loader,
        AdapterInterface $cache
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
     * @throws InvalidArgumentException
     */
    public function listPhones(): Response
    {
        $cacheItem = $this->cache->getItem('list_phone');
        if (!$cacheItem->isHit()) {
            $cacheItem->set($this->loader->load());
            $cacheItem->expiresAfter(3600);
            $this->cache->save($cacheItem);
        }
        $output = $cacheItem->get();

        return $this->sendResponse(
            $output->getItems(),
            Response::HTTP_OK,
            [],
            true
        );
    }
}
