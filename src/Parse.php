<?php

namespace TimFeid\ICS;

use Carbon\Carbon;
use RuntimeException;

class Parse
{
    protected $file;
    protected $valid = false;
    protected $contents = null;
    protected $calendar;

    public function __construct($file)
    {
        if (!is_readable($file)) {
            throw new RuntimeException("Unable to read file '$file'");
        }
        $this->calendar = new Calendar();
        $this->parse($file);
    }

    public static function file($file) {
        return new self($file);
    }

    public function isValid()
    {
        return $this->valid;
    }

    public function parse($file)
    {
        $this->contents = file_get_contents($file);
        $this->cleanContents();

        $this->valid = (bool) true;

        $this->setProduct();
        $this->setVersion();
        $this->setScale();
        $this->setMethod();
        $this->setUid();
        $this->setDescription();
        $this->setStartTime();
        $this->setEndTime();
        $this->setOrganizer();
        $this->setAttendee();
        $this->setCreated();
        $this->setTitle();
    }

    protected function cleanContents()
    {
        $this->contents = preg_replace("/\n\s/", '', $this->contents);
    }

    public function setProduct()
    {
        preg_match('~^PRODID:-//(?P<company>.+?)//(?P<version>.+?)//(?P<language>[A-Z]{2})\n~m', $this->contents, $matches);
        $product = new Product($matches['company'], $matches['version'], $matches['language']);
        $this->calendar->setProduct($product);
    }

    public function setVersion()
    {
        preg_match('~^VERSION:(?P<version>[0-9]+\.[0-9]+)\n~m', $this->contents, $matches);
        $this->calendar->setVersion($matches['version']);
    }

    public function setScale()
    {
        preg_match('~^CALSCALE:(?P<scale>\w+)\n~m', $this->contents, $matches);
        // die(var_dump($matches));
        $this->calendar->setScale($matches['scale']);
    }

    public function setMethod()
    {
        preg_match('~^METHOD:(?P<method>\w+)\n~m', $this->contents, $matches);
        // die(var_dump($matches));
        $this->calendar->setMethod($matches['method']);
    }

    public function setUid()
    {
        preg_match('~^UID:(?P<uid>\w+)\n~m', $this->contents, $matches);
        // die(var_dump($matches));
        $this->calendar->setUid($matches['uid']);
    }

    public function setTitle()
    {
        preg_match('~^SUMMARY:(?P<title>.*)\n~m', $this->contents, $matches);
        // die(var_dump($matches));
        $this->calendar->setTitle($matches['title']);
    }

    public function setDescription()
    {
        preg_match('~^DESCRIPTION:(?P<description>.*)\n~m', $this->contents, $matches);
        $this->calendar->setDescription($this->clean($matches['description']));
        // die(var_dump($this->calendar));
    }

    public function setStartTime()
    {
        preg_match('~^DTSTART:(?P<time>.*)\n~m', $this->contents, $matches);
        $this->calendar->setStartTime($this->time($matches['time']));
        // die(var_dump($this->calendar));
    }

    public function setEndTime()
    {
        preg_match('~^DTEND:(?P<time>.*)\n~m', $this->contents, $matches);
        $this->calendar->setEndTime($this->time($matches['time']));
        // die(var_dump($this->calendar));
    }

    public function setCreated()
    {
        preg_match('~^CREATED:(?P<time>.*)\n~m', $this->contents, $matches);
        $this->calendar->setCreated($this->time($matches['time']));
        // die(var_dump($this->calendar));
    }

    public function setOrganizer()
    {
        preg_match('~^ORGANIZER;?(?P<line>[^\:]+)?:(?P<link>.*)\n~m', $this->contents, $matches);

        $person = new Person($matches['link']);

        if (isset($matches['line']) && preg_match('~CN=(?P<name>[^;]+)~', $matches['line'], $matches)) {
            $person->setName($matches['name']);
        }

        $this->calendar->setOrganizer($person);
    }

    public function setAttendee()
    {
        preg_match('~^ATTENDEE;?(?P<line>[^\:]+)?:(?P<link>.*)\n~m', $this->contents, $matches);

        $person = new Person($matches['link']);

        if (isset($matches['line']) && preg_match('~CN=(?P<name>[^;]+)~', $matches['line'], $matches)) {
            $person->setName($matches['name']);
        }

        $this->calendar->setAttendee($person);
    }

    protected function clean($content)
    {
        return str_replace(['\\n', '\\'], ["\n", ''], $content);
    }

    protected function time($time)
    {
        return Carbon::parse($time);
    }

    public function __call($method, $params)
    {
        if (method_exists($this->calendar, $method)) {
            return $this->calendar->$method();
        }
    }
}
