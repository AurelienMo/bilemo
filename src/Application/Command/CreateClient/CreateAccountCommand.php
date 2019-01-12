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

namespace App\Application\Command\CreateClient;

use App\Domain\Model\Client;
use App\Domain\Model\Collaborator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateAccountCommand
 */
class CreateAccountCommand extends Command
{
    const FIELDS_TO_CREATE = [
        'username' => null,
        'email' => null,
        'password' => null,
        'role' => null
    ];

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var EncoderFactoryInterface */
    private $encoderFactory;

    /**
     * CreateAccountCommand constructor.
     *
     * @param EntityManagerInterface  $entityManager
     * @param EncoderFactoryInterface $encoderFactory
     * @param string|null             $name
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        EncoderFactoryInterface $encoderFactory,
        ?string $name = null
    ) {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setName('app:create-account')
            ->addArgument('type-user', InputArgument::REQUIRED);
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws \Exception
     */
    public function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $results = self::FIELDS_TO_CREATE;

        foreach ($results as $fieldName => $value) {
            $results[$fieldName] = $this->askForResult($input, $output, $fieldName);
        }

        $clientInput = (new GenerateClientInput())->unserialize(serialize($results));
        $entity = null;
        switch ($input->getArgument('type-user')) {
            case 'client':
                $entity = new Client(
                    $clientInput->getUsername(),
                    $this->encodePassword($clientInput->getPassword(), Client::class),
                    $clientInput->getEmail(),
                    $clientInput->getRole()
                );
                break;
            case 'collaborator':
                $entity = new Collaborator(
                    $clientInput->getUsername(),
                    $this->encodePassword($clientInput->getPassword(), Collaborator::class),
                    $clientInput->getEmail(),
                    $clientInput->getRole()
                );
        }

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param string $password
     * @param string $classEncoder
     *
     * @return string
     */
    private function encodePassword(string $password, string $classEncoder)
    {
        $encoder = $this->encoderFactory->getEncoder($classEncoder);

        return $encoder->encodePassword($password, '');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param string          $fieldName
     *
     * @return mixed
     */
    private function askForResult(InputInterface $input, OutputInterface $output, string $fieldName)
    {
        $question = new Question(sprintf("Enter %s : ", $fieldName));

        return $this->getHelperQuestion()->ask($input, $output, $question);
    }

    /**
     * @return mixed
     */
    private function getHelperQuestion()
    {
        return $this->getHelper('question');
    }
}
