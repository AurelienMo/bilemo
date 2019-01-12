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

/**
 * Class GenerateClientInput
 */
class GenerateClientInput implements \Serializable
{
    /** @var string */
    protected $username;

    /** @var string */
    protected $email;

    /** @var string */
    protected $password;

    /** @var string */
    protected $role;

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
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    public function serialize()
    {
    }

    public function unserialize($serialized)
    {
        list(
            $this->username,
            $this->email,
            $this->password,
            $this->role
            ) = array_values(unserialize($serialized));

        return $this;
    }
}
