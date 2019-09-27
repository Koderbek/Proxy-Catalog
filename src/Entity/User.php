<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 26.09.2019
 * Time: 8:46
 */

namespace App\Entity;


use App\Helper\UserRoles;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Entity()
 * @UniqueEntity("login", message="Данный login уже зарегистрирован")
 */
class User implements UserInterface
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Заполните поле")
     */
    protected $login;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Заполните поле")
     */
    protected $role;

    /**
     * @var string
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Введите пароль")
     * @Assert\Length(
     *     min=8,
     *     max=20,
     *     minMessage="Ваш пароль должен быть как минимум {{ limit }} символов",
     *     maxMessage="Ваш пароль не должен быть длиннее {{ limit }} символов"
     * )
     */
    protected $password;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    protected $salt;

    public function __construct()
    {
        $this->role = UserRoles::EDITOR;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login)
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    public function getRoles()
    {
        return [$this->role];
    }

    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function __toString()
    {
        return $this->getLogin();
    }
}