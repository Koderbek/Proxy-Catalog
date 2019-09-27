<?php
/**
 * Created by PhpStorm.
 * User: Юрий
 * Date: 26.09.2019
 * Time: 8:38
 */

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class Proxy
 * @package App\Entity
 *
 * @ORM\Entity()
 */
class Proxy
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
    protected $ip;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     *
     * @Assert\NotBlank(message="Заполните поле")
     */
    protected $port;

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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp(string $ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param int $port
     */
    public function setPort(int $port)
    {
        $this->port = $port;
    }

    public function __toString()
    {
        return $this->getIp() . '::' . $this->getPort();
    }
}