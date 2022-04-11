<?php

namespace EfTech\SportClub\Entity;

use Doctrine\ORM\Mapping AS ORM;

/**
 * Пользователь системы
 *
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{

    /**
     * Идендификатор пользователя в системе
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer", nullable=false)
     *
     * @var integer
     */
    private int $id;

    /**
     * Логин пользователя в системе
     *
     * @ORM\Column(name="login", type="string", length=50, nullable=false)
     *
     * @var string
     */
    private string $login;

    /**
     * Пароль пользователя в системе
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=false)
     *
     * @var string
     */
    private string $password;


    /**
     * @param integer $id       - идендификатор пользователя в системе
     * @param string  $login    - логин пользователя в системе
     * @param string  $password - пользователя в системе
     */
    public function __construct(
        int $id,
        string $login,
        string $password
    ) {
        $this->id       = $id;
        $this->login    = $login;
        $this->password = $password;

    }//end __construct()


    /**
     * Возвращает идендификатор пользователя в системе
     *
     * @return integer
     */
    public function getId(): int
    {
        return $this->id;

    }//end getId()


    /**
     * Возвращает логин пользователя в системе
     *
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;

    }//end getLogin()


    /**
     * Возвращает пароль пользователя в системе
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;

    }//end getPassword()


}//end class
