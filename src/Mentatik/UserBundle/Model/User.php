<?php

namespace Mentatik\UserBundle\Model;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="User")
 */
class User
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    protected $id;

    /**
     * @var Ship[]|Collection
     *
     * @OGM\Relationship(type="ACTED_IN", direction="OUTGOING", collection=true, mappedBy="users", targetEntity="Ship")
     */
    protected $ships;

    public function __construct()
    {
        $this->ships = new Collection();
    }

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $name;

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $email;

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->name);
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return Ship[]|Collection
     */
    public function getShips()
    {
        return $this->ships;
    }
}