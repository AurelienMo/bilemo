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
 * Class Client
 */
class Client extends AbstractModel implements UserInterface
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $password;

    /** @var string */
    protected $email;

    /** @var array */
    protected $roles;

    /**
     * Client constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $role
     *
     * @throws \Exception
     */
    public function __construct(
        string $username,
        string $password,
        string $email,
        string $role = 'ROLE_CLIENT'
    ) {
        parent::__construct();
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
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
    public function getPassword(): string
    {
        return $this->password;
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

    public function getSalt()
    {
        return;
    }

    public function eraseCredentials()
    {
        return;
    }
}
