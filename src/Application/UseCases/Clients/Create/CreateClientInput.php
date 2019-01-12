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

use App\Application\UseCases\InputInterface;
use App\Application\Validators\UniqueEntityInput;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CreateClientInput
 *
 * @UniqueEntityInput(
 *     class="App\Domain\Model\Client",
 *     fields={"username", "email"},
 *     message="Un compte client est déjà existant avec cet identiant, adresse email."
 * )
 */
class CreateClientInput implements InputInterface
{
    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Un nom d'utilisateur est requis."
     * )
     */
    protected $username;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Une adresse email est requise."
     * )
     */
    protected $email;

    /**
     * @var string|null
     *
     * @Assert\NotBlank(
     *     message="Vous devez spécifier un mot de passe."
     * )
     */
    protected $password;

    /** @var string|null */
    protected $role;

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @param string|null $role
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }
}
