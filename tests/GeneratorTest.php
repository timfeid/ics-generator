<?php

use Carbon\Carbon;
use TimFeid\ICS\Person;
use TimFeid\ICS\Calendar;
use TimFeid\ICS\Generator;

class GeneratorTest extends TestCase {

    public function testCal()
    {
        $startTime = Carbon::now()->addMinutes(10);
        $endTime = Carbon::now()->addMinutes(70);
        $calendar = new Calendar();
        $calendar->setDescription(implode("\n", $this->faker->paragraphs));
        $calendar->setStartTime($startTime);
        $calendar->setEndTime($endTime);
        $calendar->setTitle('Some awesome event');
        $calendar->setOrganizer(new Person('mailto:support@continuumeconomics.com', 'Continuum Economics'));
        $calendar->setAttendee(new Person('mailto:tim.feid@roubini.com', 'Tim Feid'));

        $generator = new Generator($calendar);
        $generator->withAlert()->build();
        var_dump((string) $generator);
    }

}