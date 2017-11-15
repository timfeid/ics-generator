<?php

namespace TimFeid\ICS;

class Person
{
    protected $link;
    protected $name;
    public function __construct($link, $name = '')
    {
        $this->link = $link;
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function asProperty($name)
    {
        $property = new Property($name, $this->link);
        if ($this->name) {
            $property->setAttribute('CN', $this->name);
        }

        return $property;
    }
}
