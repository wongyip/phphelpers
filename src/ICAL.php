<?php namespace Wongyip\PHPHelpers;

/**
 * ICAL Maker Class.
 *  
 * @author Wongyip
 */
class ICAL extends Base
{
    /**
     * Unique ID of the event. It is important to keep the UID unchanged if an
     * event is rescheduled, mail clients like Outlook uses it to determine if
     * this is an new event or just a change of scghedule.
     *
     * @var string
     */
    public $UID;
    /**
     * GMDATE
     * @var string
     */
    public $dateNow;
    /**
     * GMDATE
     * @var string
     */
    public $dateStart;
    /**
     * GMDATE
     * @var string
     */
    public $dateEnd;
    /**
     * e.g. "Annual Conference"
     * @var string
     */
    public $summary;
    /**
     * e.g. "Whatever simple description, as simple as it can."
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
    static function __usage()
    {
        // Fill in all properties in your own way and call the make() method.
        return true;
        // Sample code
        $ical = new static();
        $ical->UID        = md5($event->id);
        $ical->dateNow    = gmdate("Ymd\THis\Z");
        $ical->dateStart  = gmdate("Ymd\THis\Z", strtotime($event->date . ' ' . $event->time_start));
        $ical->dateEnd    = gmdate("Ymd\THis\Z", strtotime($event->date . ' ' . $event->time_end));
        $ical->summary    = $event->title;
        $ical->description= $event->descrition;
        $ical->venue      = $event->venue;
        $ical->url        = "https://www.example.com/events";
        $ical->calName    = "Example Calendar";
        $ical->mailerFrom = "service@example.com";
        return $ical->make();
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
UID:$UID
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
