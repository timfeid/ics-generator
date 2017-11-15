<?php

namespace TimFeid\ICS;

class Generator
{
    const DATE_FORMAT = 'Ymd\THis\Z';
    protected $properties = [];
    protected $calendar;
    protected $alert = false;
    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }

    public function withAlert()
    {
        $this->alert = true;
        return $this;
    }

    public function withoutAlert()
    {
        $this->alert = false;
        return $this;
    }

    public function build()
    {
        $this->properties = [];
        $this->properties[] = new Property('BEGIN', 'VCALENDAR');
        $this->properties[] = new Property('PRODID', (string) $this->calendar->getProduct());
        $this->properties[] = new Property('VERSION', $this->calendar->getVersion());
        $this->properties[] = new Property('CALSCALE', $this->calendar->getScale());
        $this->properties[] = new Property('BEGIN', 'VEVENT');
        $this->properties[] = new Property('DTSTART', $this->calendar->getStartTime()->timezone('UTC')->format(self::DATE_FORMAT));
        $this->properties[] = new Property('DTEND', $this->calendar->getEndTime()->timezone('UTC')->format(self::DATE_FORMAT));
        $this->properties[] = $this->calendar->getOrganizer()->asProperty('ORGANIZER');
        $this->properties[] = new Property('UID', $this->calendar->getUid());
        $this->properties[] = $this->calendar->getAttendee()->asProperty('ATTENDEE');
        $this->properties[] = new Property('DESCRIPTION', $this->calendar->getDescription());
        $this->properties[] = new Property('SUMMARY', $this->calendar->getTitle());
        $this->properties[] = new Property('END', 'VEVENT');
        $this->properties[] = new Property('END', 'VCALENDAR');
        if ($this->alert) {
            $this->properties[] = new Property('BEGIN', 'VALARM');
            $this->properties[] = new Property('ACTION', 'DISPLAY');
            $this->properties[] = new Property('DESCRIPTION', 'This is an event reminder');
            $this->properties[] = new Property('TRIGGER', '-P0DT0H15M0S');
            $this->properties[] = new Property('END', 'VALARM');
        }
    }

    public function get()
    {
        return implode("\n\r", $this->properties)."\n\r";
    }

    public function __toString()
    {
        return $this->get();
    }
}
