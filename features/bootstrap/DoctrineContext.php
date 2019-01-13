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

use App\Domain\Model\AbstractModel;
use App\Domain\Model\Client;
use App\Domain\Model\Collaborator;
use App\Domain\Model\Phone;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Tools\SchemaTool;
use Nelmio\Alice\Loader\NativeLoader;
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

    /** @var string */
    private $prodFixtures;

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
        $this->prodFixtures = $this->kernel->getContainer()->getParameter('prodfixtures');
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
     * @Given I load following collaborators:
     *
     * @throws Exception
     */
    public function iLoadFollowingCollaborators(TableNode $table)
    {
        foreach ($table->getHash() as $hash) {
            $client = new Collaborator(
                $hash['username'],
                $hash['email'],
                $this->getEncoder()->encodePassword($hash['password'], ''),
                $hash['role']
            );

            $this->getManager()->persist($client);
        }

        $this->getManager()->flush();
    }

    /**
     * @Given I load prod datas
     */
    public function iLoadProdDatas()
    {
        $loader = new NativeLoader();
        $objectSet = $loader->loadFile($this->prodFixtures);

        foreach ($objectSet->getObjects() as $object) {
            $this->getManager()->persist($object);
        }

        $this->getManager()->flush();
    }

    /**
     * @Given phone with name :name must return following unique identifier :newuuid
     */
    public function phoneWithNameMustReturnFollowingUniqueIdentifier($name, $newuuid)
    {
        $phone = $this->getManager()->getRepository(Phone::class)->findOneBy(['name' => $name]);

        $this->setUuid($phone, $newuuid);
        $this->getManager()->flush();
    }

    /**
     * @return PasswordEncoderInterface
     */
    private function getEncoder()
    {
        return $this->encoderFactory->getEncoder(Client::class);
    }

    private function setUuid(AbstractModel $entity, string $uuid)
    {
        $reflection = new \ReflectionClass($entity);
        $property = $reflection->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($entity, $uuid);
    }
}
