<?php

use Carbon\Carbon;
use TimFeid\ICS\Parse;
use TimFeid\ICS\Calendar;

class ParseTest extends TestCase
{
    protected $parsed;

    public function setUp()
    {
        $this->parsed = Parse::file(realpath(dirname(__FILE__)).'/test.ics');
    }

    public function testCheckIsValid()
    {
        $this->assertEquals(true, $this->parsed->isValid());
    }

    public function testProduct()
    {
        // PRODID:-//Google Inc//Google Calendar 70.9054//EN
        $this->assertEquals('Google Inc', $this->parsed->getProduct()->getCompany());
        $this->assertEquals('Google Calendar 70.9054', $this->parsed->getProduct()->getVersion());
        $this->assertEquals('EN', $this->parsed->getProduct()->getLanguage());
    }

    public function testVersion()
    {
        $this->assertEquals('2.0', $this->parsed->getVersion());
    }

    public function testScale()
    {
        $this->assertEquals(Calendar::SCALE_GREGORIAN, $this->parsed->getScale());
    }

    public function testMethod()
    {
        $this->assertEquals(Calendar::METHOD_REPLY, $this->parsed->getMethod());
    }

    public function testStartTime()
    {
        $carbon = Carbon::parse('20171121T140000Z');
        $this->assertEquals($carbon->toAtomString(), $this->parsed->getStartTime()->toAtomString());
    }

    public function testEndTime()
    {
        $carbon = Carbon::parse('20171121T150000Z');
        $this->assertEquals($carbon->toAtomString(), $this->parsed->getEndTime()->toAtomString());
    }

    public function testOrganizer()
    {
        $this->assertEquals('RGE Support', $this->parsed->getOrganizer()->getName());
        $this->assertEquals('mailto:support@roubini.com', $this->parsed->getOrganizer()->getLink());
    }

    public function testUid()
    {
        $this->assertEquals('1510032793addeventcom', $this->parsed->getUid());
    }

    public function testAttendee()
    {
        $this->assertEquals('praveen@klaycapital.com', $this->parsed->getAttendee()->getName());
        $this->assertEquals('mailto:praveen@klaycapital.com', $this->parsed->getAttendee()->getLink());
    }

    public function testCreated()
    {
        $carbon = Carbon::parse('20171107T053322Z');
        $this->assertEquals($carbon->toAtomString(), $this->parsed->getCreated()->toAtomString());
    }

    public function testDescription()
    {
        $this->assertEquals("Conference Details

Meeting title: Key Global Themes for 2018
Meeting date: November 21st, 2017
Start time: 09:00 AM EST
Duration: 1 Hour

Audio conference details

Primary dial-in number(s) US : UnitedStates Toll free: 1 800 219.3192
United States International direct: +1 617 597.5412
Primary dial-in number(s) UK : United Kingdom Toll free: 080 0055 6013United Kingdom Toll free: 080 0085 8265

United Kingdom International/local direct: +44 (0) 20 7136 5118
United Kingdom International/localdirect: +44 (0) 20 3027 7073
Global Access Dial-in Numbers: http://www.btconferencing.com/globalaccess/?bid=288_automated
Participant passcode: 64536434
Pre-registration Pin: 54278

How to Join Your Conference
To join the audio conference
A few minutes before the start of your conference:

Call one of the dial-in numbers listed above under Audio conference details. If you are located outside of North America, and want to use a dial-in number within your country, look up your Global Access Number at: http://www.btconferencing.com/globalaccess/?bid=288_automated .
When prompted, enter your participant passcode followed by the # sign on your telephone keypad.
At the prompt, enter your Pre-registration Pin followed by the # sign on your telephone keypad.
Depending on the options selected for this conference call, you will either be entered directly into the conference or you will hear music until the conference begins.

Every year, we produce a number of themes, ideas or trends that we believe are likely to characterize the coming year.

Our themes for 2018 will include divergent DM monetary policy; stronger growth and tighter policy in EMs; the reconnection of politics and markets; and housing bubbles and contagion.", $this->parsed->getDescription());
    }
}
