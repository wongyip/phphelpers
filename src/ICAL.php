<?php namespace Wongyip\PHPHelpers;

class ICAL extends Base
{
    /**
     * date('Y-m-d H:i:s')
     * @var string
     */
    public $dateNow;
    /**
     * date('Y-m-d H:i:s')
     * @var string
     */
    public $dateStart;
    /**
     * date('Y-m-d H:i:s')
     * @var string
     */
    public $dateEnd;
    /**
     * e.g. "Workshop No. LS123"
     * @var string
     */
    public $summary;
    /**
     * e.g. "What ever simpel description, as simple as it can."
     * @var string
     */
    public $description;
    /**
     * e.g. "Room 1123"
     * @var string
     */
    public $venue;
    /**
     * URL (no validation)
     * @var string
     */
    public $url;
    /**
     * Calender name, good to keep it the same across your app.
     * @var string
     */
    public $calName;
    /**
     * From Address
     * @var string email address
     */
    public $mailerFrom;
    /**
     * ProductID. For real, this is useless at all.
     * @var string
     */
    public $prodId = '-//Wongyip/iCalMaker//NONSGML v1.0//EN';
    /**
     * Learn how to use here.
     */
    public function __usage()
    {
        // Fill in all properties in your own way and call the make() method.
        return true;
        // Sample code
        $this->dateNow    = gmdate("Ymd\THis\Z");
        $this->dateStart  = gmdate("Ymd\THis\Z", strtotime($event->date . ' ' . $event->time_start));
        $this->dateEnd    = gmdate("Ymd\THis\Z", strtotime($event->date . ' ' . $event->time_end));
        $this->summary    = $event->title;
        $this->description= $event->descrition;
        $this->venue      = $event->venue;
        $this->url        = "https://www.example.com/events";
        $this->calName    = "Example Calendar";
        $this->mailerFrom = "service@example.com";
        return $this->make();
    }
    /**
     * Make an ICAL string with current properties. Output sample: "BEGIN:VCALENDART...END:VCALENDAR"
     * 
     * To add attachment using PHPMailer:
     *  $phpmailer->addStringAttachment(
     *      $ical_string,
     *      $ical_filename,
     *      "7bit",
     *      "text/calendar; charset=utf-8; method=REQUEST"
     *  );
     * 
     * @param string $filename
     * @return string
     */
    public function make()
    {
        $properties = $this->toArray();
        extract($properties);
        // Make it
        $ical = "BEGIN:VCALENDAR
METHOD:REQUEST
VERSION:2.0
X-WR-CALNAME:$calName
PRODID:$prodId
BEGIN:VEVENT
ORGANIZER:MAILTO:$mailerFrom
DTSTAMP:$dateNow
DTSTART:$dateStart
DTEND:$dateEnd
LOCATION:$venue
SUMMARY:$summary
UID:$mailerFrom
DESCRIPTION:$description
URL;VALUE=URI:$url
END:VEVENT
END:VCALENDAR";
        // Byebye tabs
        // $ical = preg_replace("/$\s+/m", "", $ical);
        // $ical = preg_replace("/$\s+/m", "", $ical);
        return $ical;
    }
}
