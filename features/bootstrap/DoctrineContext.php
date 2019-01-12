<?php

declare(strict_types=1);

/*
 * This file is part of homemanagement-be
 *
 * (c) Aurelien Morvan <morvan.aurelien@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Domain\Model\Client;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * Class DoctrineContext
 */
class DoctrineContext implements Context
{
    /** @var SchemaTool */
    private $schemaTool;

    /** @var RegistryInterface */
    private $doctrine;

    /** @var KernelInterface */
    private $kernel;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;
    /**
     * DoctrineContext constructor.
     *
     * @param RegistryInterface            $doctrine
     * @param KernelInterface              $kernel
     * @param EncoderFactoryInterface      $encoderFactory
     */
    public function __construct(
        RegistryInterface $doctrine,
        KernelInterface $kernel,
        EncoderFactoryInterface $encoderFactory
    ) {
        $this->doctrine = $doctrine;
        $this->schemaTool = new SchemaTool($this->doctrine->getManager());
        $this->kernel = $kernel;
        $this->encoderFactory = $encoderFactory;
    }
    /**
     * @BeforeScenario
     *
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    public function clearDatabase()
    {
        $this->schemaTool->dropSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
        $this->schemaTool->createSchema($this->doctrine->getManager()->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @return ObjectManager
     */
    public function getManager()
    {
        return $this->doctrine->getManager();
    }

    /**
     * @Given I load following clients:
     *
     * @throws \Exception
     */
    public function iLoadFollowingClients(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $client = new Client(
                $hash['username'],
                $this->getEncoder()->encodePassword($hash['password'], ''),
                $hash['email'],
                $hash['role']
            );

            $this->getManager()->persist($client);
        }

        $this->getManager()->flush();
    }

    /**
     * @return PasswordEncoderInterface
     */
    private function getEncoder()
    {
        return $this->encoderFactory->getEncoder(Client::class);
    }
}
