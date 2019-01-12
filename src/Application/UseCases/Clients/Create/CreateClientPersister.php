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

use App\Application\UseCases\AbstractPersister;
use App\Application\UseCases\InputInterface;
use App\Application\UseCases\Output\LocationOutput;
use App\Application\UseCases\OutputInterface;
use App\Domain\Builders\ClientBuilder;
use App\Domain\Model\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateClientPersister
 */
class CreateClientPersister extends AbstractPersister
{
    /** @var EncoderFactoryInterface */
    protected $encoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->encoder = $encoderFactory;
        parent::__construct($entityManager, $urlGenerator);
    }

    /**
     * @param InputInterface|CreateClientInput $input
     *
     * @return OutputInterface|null
     *
     * @throws \Exception
     */
    public function save(InputInterface $input): ?OutputInterface
    {
        $client = ClientBuilder::create(
            $input->getUsername(),
            ($this->encoder->getEncoder(Client::class))->encodePassword($input->getPassword(), ''),
            $input->getEmail(),
            $input->getRole() ?? null
        );

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return new LocationOutput(
            $this->urlGenerator->generate('show_client', ['id' => $client->getId()->toString()])
        );
    }

    protected function getClassRepository(): string
    {
        return Client::class;
    }
}
