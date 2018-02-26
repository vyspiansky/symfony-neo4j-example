<?php

namespace Mentatik\UserBundle\Model;

use GraphAware\Neo4j\OGM\Annotations as OGM;
use GraphAware\Neo4j\OGM\Common\Collection;

/**
 * @OGM\Node(label="Ship")
 */
class Ship
{
    /**
     * @OGM\GraphId()
     * @var int
     */
    protected $id;

    /**
     * @OGM\Property(type="string")
     * @var string
     */
    protected $title;

    /**
     * @var User[]|Collection
     *
     * @OGM\Relationship(type="ACTED_IN", direction="INCOMING", collection=true, mappedBy="ships", targetEntity="User")
     */
    protected $users;

    public function __construct()
    {
        $this->users = new Collection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->title);
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

}