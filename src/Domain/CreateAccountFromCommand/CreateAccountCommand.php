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

namespace App\Domain\CreateAccountFromCommand;

use App\Domain\Common\Builders\CollaboratorBuilder;
use App\Entity\Client;
use App\Entity\Collaborator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

/**
 * Class CreateAccountCommand
 */
class CreateAccountCommand extends Command
{
    const LIST_FIELD_TO_CREATE_ACCOUNT = [
        'username' => null,
        'password' => null,
        'email' => null,
        'role' => null,
    ];

    /** @var EntityManagerInterface */
    protected $entityManager;

    /** @var EncoderFactoryInterface */
    protected $encoderFactory;

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
            ->setDescription('Allow to create collaborator or client account');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     *
     * @throws \Exception
     */
    protected function execute(
        InputInterface $input,
        OutputInterface $output
    ) {
        $listFields = self::LIST_FIELD_TO_CREATE_ACCOUNT;
        foreach (self::LIST_FIELD_TO_CREATE_ACCOUNT as $key => $value) {
            $question = null;
            if ('role' !== $key) {
                $question = new Question(sprintf('Merci de saisir une valeur pour %s : ', $key));
            } else {
                $question = new ChoiceQuestion(
                    'Merci de choisir le rôle du compte à créer',
                    ['ROLE_COLLABORATOR', 'ROLE_CLIENT']
                );
            }
            $listFields[$key] = $this->getQuestionHelper()->ask($input, $output, $question);
        }

        $object = $this->createAccountObject($listFields);

        $this->entityManager->persist($object);
        $this->entityManager->flush();
    }

    /**
     * @param array $listFields
     *
     * @return Collaborator
     *
     * @throws \Exception
     */
    private function createAccountObject(array $listFields)
    {
        $typeAccount = in_array('ROLE_COLLABORATOR', $listFields) ? 'collaborator' : 'client';
        $passwordEncoded = $this->getEncoder($typeAccount)->encodePassword($listFields['password'], '');

        return $typeAccount === 'collaborator' ?
            CollaboratorBuilder::create(
                $listFields['username'],
                $passwordEncoded,
                $listFields['email'],
                $listFields['role']
            ) :
            Client::create(
                $listFields['username'],
                $passwordEncoded,
                $listFields['email'],
                $listFields['role']
            );
    }

    private function getEncoder(string $type)
    {
        return $this->encoderFactory->getEncoder($type === 'collaborator' ? Collaborator::class : Client::class);
    }

    private function getQuestionHelper()
    {
        return $this->getHelper('question');
    }
}
