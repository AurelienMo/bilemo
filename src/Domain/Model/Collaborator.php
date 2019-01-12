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

namespace App\Domain\Model;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class Collaborator
 */
class Collaborator extends AbstractModel implements UserInterface
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $email;

    /** @var array */
    protected $roles;

    /** @var string */
    protected $password;

    public function __construct(
        string $username,
        string $email,
        string $password,
        string $role = 'ROLE_COLLABORATOR'
    ) {
        parent::__construct();
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->roles[] = $role;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
        return;
    }
}
