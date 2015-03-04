<?php

namespace HatueySoft\SecurityBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @author: firomero <firomerorom4@gmail.com>
 * @author: dundivet <dundivet@emailn.de>
 *
 * @ORM\Entity
 * @ORM\Table(name="security_fos_user")
 * @UniqueEntity(fields={"username", "email"})
 */
class EUsuario extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="HatueySoft\SecurityBundle\Entity\EGrupo")
     * @ORM\JoinTable(name="security_fos_users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $nombre;

    public function isActive()
    {
        return $this->locked == false;
    }

    public function setActive($value)
    {
        $this->locked = !$value;
    }

    public  function getId()
    {
        return $this->id;
    }

} 