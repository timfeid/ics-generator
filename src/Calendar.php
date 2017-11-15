<?php

namespace TimFeid\ICS;

class Calendar
{
    const SCALE_GREGORIAN = 'GREGORIAN';

    const METHOD_REPLY = 'REPLY';

    protected $product;
    protected $version = '2.0';
    protected $scale;
    protected $method;
    protected $startTime;
    protected $endTime;
    protected $organizer;
    protected $uid;
    protected $attendee;
    protected $created;
    protected $description;

    public function __construct()
    {
        $this->product = new Product('timfeid/ics-generator', 'ics generator v1', 'EN');
        $this->method = self::METHOD_REPLY;
        $this->scale = self::SCALE_GREGORIAN;
        $this->uid = uniqid();
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getScale()
    {
        return $this->scale;
    }

    public function setScale($scale)
    {
        $this->scale = $scale;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime()
    {
        return $this->endTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getOrganizer()
    {
        return $this->organizer;
    }

    public function setOrganizer(Person $organizer)
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getAttendee()
    {
        return $this->attendee;
    }

    public function setAttendee(Person $attendee)
    {
        $this->attendee = $attendee;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
