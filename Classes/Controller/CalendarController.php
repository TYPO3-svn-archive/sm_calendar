<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 *
 * @package sm_calendar
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */

class Tx_SmCalendar_Controller_CalendarController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * calendarRepository
	 *
	 * @var Tx_SmCalendar_Domain_Repository_CalendarRepository
	 */
	protected $calendarRepository;

    protected $nextMonth;
    protected $previousMonth;
    protected $dayCount;
    protected $firstDayOfMonth;
    protected $currentMonth;
    protected $currentMonthNumericSingle;
    protected $currentYear;

    /**
	 * injectCalendarRepository
	 *
	 * @param Tx_SmCalendar_Domain_Repository_CalendarRepository $calendarRepository
	 * @return void
	 */
	public function injectCalendarRepository(Tx_SmCalendar_Domain_Repository_CalendarRepository $calendarRepository) {
		$this->calendarRepository = $calendarRepository;
	}

	/**
	 * action list
	 *
	 * @return void
     * @param string $listPerspective
     * @dontvalidate $listPerspective
     * @param string $displaydate
     * @dontvalidate $displaydate
	 */
	public function listAction($listPerspective=NULL, $displaydate=NULL ) {
		$calendars = $this->calendarRepository->findAll();
        if (!$displaydate){
            $displaydate = date('m_Y');
        }
        $dateParts = explode("_", $displaydate);
        $time = strtotime($dateParts[1]."-".$dateParts[0]."-01");
        // validate input
        if (!$time){
            //TODO: throw exception
            echo "error";
        }
        if ($listPerspective == '1'){
           $listPerspective = true;
        } else {
           $listPerspective = false;
        }
        $this->calculateImportantInformations($time);
        $entries = $this->getCalendarEntries($calendars);
        $preRenderContent = $this->preRenderCalendar($displaydate, $entries);
        $calendars = $this->generateAddLink($calendars);
        $calendars = $this->calculateColorVariance($calendars);

        $this->view->assign('preRenderContent', $preRenderContent);
        $this->view->assign('listPerspective', $listPerspective);
        $this->view->assign('calendars', $calendars);
        $this->view->assign('nextMonth', $this->nextMonth);
        $this->view->assign('previousMonth', $this->previousMonth);
        $this->view->assign('currentMonth', $this->currentMonth);
        $this->view->assign('currentMonthNumericSingle', $this->currentMonthNumericSingle);
        $this->view->assign('currentYear', $this->currentYear);
	}

    private function generateAddLink($calendars){
        foreach ($calendars as $calendar){
            $icalLink = $calendar->getICalAddress();
            $parts = explode('/', $icalLink);
            $calendar->setAddLink('https://www.google.com/calendar/render?cid='.$parts[5].'&pli=1');
        }
        return $calendars;

    }

    /**
     * @param $calendars
     * -> VIEW
     */
    private function calculateColorVariance($calendars){
        foreach ($calendars as $calendar){
            $color = $calendar->getColor();
            $color = trim($color, '#');
            $rgb = $this->html2rgb($color);
            $darkerColor = array();
            foreach ($rgb as $colorPart){
                $darkerColorPart = $colorPart - 100;

                if ($darkerColorPart <= 0){
                    $darkerColor[] = '00';
                } elseif (strlen(dechex($darkerColorPart)) == 1) {
                   $darkerColor[] = '0'.dechex($darkerColorPart);
                } else {
                    $darkerColor[] = dechex($darkerColorPart);
                }
            }
            $darkerColor = '#'.implode('', $darkerColor);
            $calendar->setDarkerColor($darkerColor);
        }
        return $calendars;
    }

    private function html2rgb($color){
        if ($color[0] == '#')
            $color = substr($color, 1);

        if (strlen($color) == 6)
            list($r, $g, $b) = array($color[0].$color[1],
                $color[2].$color[3],
                $color[4].$color[5]);
        elseif (strlen($color) == 3)
            list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
        else
            return false;

        $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

        return array($r, $g, $b);
    }

    private function calculateImportantInformations($time){
        $this->dayCount = date("t", $time);
        $this->firstDayOfMonth = date("N", $time)-1;
        $this->currentMonth = date("m_Y", $time);
        $this->currentMonthNumericSingle = date("m", $time);
        $this->currentYear = date("Y", $time);
        $this->nextMonth = date("m_Y", strtotime("+1 month", $time));
        $this->previousMonth = date("m_Y", strtotime("-1 month", $time));
    }

    private function getCalendarEntries($calendars){
        foreach ($calendars as $calendar){
            $ical = new ICal($calendar->getICalAddress());
            $color = $calendar->getColor();
            $events = $ical->events();
            foreach ($events as $event){
                if (date("m_Y",$this->iCalDateToUnixTimestamp($event['DTSTART'])) == $this->currentMonth){
                    $event['calendar'] = $calendar->getUid();
                    $event['color'] = $color;
                    $entries[] = $event;
                }
            }
        }
        return $entries;
    }

    private function arraySort($a,$b){
        if ($a['starttime'] == $b['starttime']){
            return 0;
        } else {
            return ($a < $b) ? -1 : 1;
        }
    }

    private function preRenderCalendar($displaydate, $entries){
        $preRendered = array();

        foreach ($entries as $entry){
            $unixTimeStampStart = $this->iCalDateToUnixTimestamp($entry['DTSTART']);
            $day = date("j",$unixTimeStampStart);
            $startHour = date("H",$unixTimeStampStart)+1;
            $entry['starttime'] = $startHour.':'.date("i",$unixTimeStampStart);

            $unixTimeStampEnd = $this->iCalDateToUnixTimestamp($entry['DTEND']);
            $endHour = date("H",$unixTimeStampEnd)+1;
            $entry['endtime'] = $endHour.':'.date("i",$unixTimeStampEnd);
            $appointments[$day][] = $entry;
        }


        for ($i=0; $i !== $this->firstDayOfMonth; $i++){
            $preRendered[$i] = array("skip"=> "1");
        }
        $i++;
        for ($y=1; $y <= $this->dayCount; $y++){
            if (is_array($appointments[$y])){
                uasort($appointments[$y], array('Tx_SmCalendar_Controller_CalendarController','arraySort'));
            }
            $preRendered[$i] = array( "day" => $y,
                                      "month" => $this->currentMonthNumericSingle,
                                      "appointments" => $appointments[$y]
                                    );
            if ($this->currentMonth == date("m_Y") && $y == date("j")){
                $preRendered[$i]['today'] = true;
            }
            $i++;
        }

        return $preRendered;
    }

    /**
     * Return Unix timestamp from ical date time format
     *
     * @param {string} $icalDate A Date in the format YYYYMMDD[T]HHMMSS[Z] or
     *                           YYYYMMDD[T]HHMMSS
     *
     * @return {int}
     */
    public function iCalDateToUnixTimestamp($icalDate)
    {
        $icalDate = str_replace('T', '', $icalDate);
        $icalDate = str_replace('Z', '', $icalDate);

        $pattern  = '/([0-9]{4})';   // 1: YYYY
        $pattern .= '([0-9]{2})';    // 2: MM
        $pattern .= '([0-9]{2})';    // 3: DD
        $pattern .= '([0-9]{0,2})';  // 4: HH
        $pattern .= '([0-9]{0,2})';  // 5: MM
        $pattern .= '([0-9]{0,2})/'; // 6: SS
        preg_match($pattern, $icalDate, $date);

        // Unix timestamp can't represent dates before 1970
        if ($date[1] <= 1970) {
            return false;
        }
        // Unix timestamps after 03:14:07 UTC 2038-01-19 might cause an overflow
        // if 32 bit integers are used.
        $timestamp = mktime((int)$date[4],
            (int)$date[5],
            (int)$date[6],
            (int)$date[2],
            (int)$date[3],
            (int)$date[1]);
        return  $timestamp;
    }
}


/**
 * This is the iCal-class
 *
 * @category Parser
 * @package  Ics-parser
 * @author   Martin Thoma <info@martin-thoma.de>
 * @license  http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link     http://code.google.com/p/ics-parser/
 *
 * @param {string} filename The name of the file which should be parsed
 * @constructor
 */
class ICal
{
    /* How many ToDos are in this ical? */
    public  /** @type {int} */ $todo_count = 0;

    /* How many events are in this ical? */
    public  /** @type {int} */ $event_count = 0;

    /* The parsed calendar */
    public /** @type {Array} */ $cal;

    /* Which keyword has been added to cal at last? */
    private /** @type {string} */ $_lastKeyWord;

    /**
     * Creates the iCal-Object
     *
     * @param {string} $filename The path to the iCal-file
     *
     * @return Object The iCal-Object
     */
    public function __construct($filename)
    {
        if (!$filename) {
            return false;
        }

        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (stristr($lines[0], 'BEGIN:VCALENDAR') === false) {
            return false;
        } else {
            // TODO: Fix multiline-description problem (see http://tools.ietf.org/html/rfc2445#section-4.8.1.5)
            foreach ($lines as $line) {
                $line = trim($line);
                $add  = $this->keyValueFromString($line);
                if ($add === false) {
                    $this->addCalendarComponentWithKeyAndValue($type, false, $line);
                    continue;
                }

                list($keyword, $value) = $add;

                switch ($line) {
                    // http://www.kanzaki.com/docs/ical/vtodo.html
                    case "BEGIN:VTODO":
                        $this->todo_count++;
                        $type = "VTODO";
                        break;

                    // http://www.kanzaki.com/docs/ical/vevent.html
                    case "BEGIN:VEVENT":
                        //echo "vevent gematcht";
                        $this->event_count++;
                        $type = "VEVENT";
                        break;

                    //all other special strings
                    case "BEGIN:VCALENDAR":
                    case "BEGIN:DAYLIGHT":
                        // http://www.kanzaki.com/docs/ical/vtimezone.html
                    case "BEGIN:VTIMEZONE":
                    case "BEGIN:STANDARD":
                        $type = $value;
                        break;
                    case "END:VTODO": // end special text - goto VCALENDAR key
                    case "END:VEVENT":
                    case "END:VCALENDAR":
                    case "END:DAYLIGHT":
                    case "END:VTIMEZONE":
                    case "END:STANDARD":
                        $type = "VCALENDAR";
                        break;
                    default:
                        $this->addCalendarComponentWithKeyAndValue($type,
                            $keyword,
                            $value);
                        break;
                }
            }
            return $this->cal;
        }
    }

    /**
     * Add to $this->ical array one value and key.
     *
     * @param {string} $component This could be VTODO, VEVENT, VCALENDAR, ...
     * @param {string} $keyword   The keyword, for example DTSTART
     * @param {string} $value     The value, for example 20110105T090000Z
     *
     * @return {None}
     */
    public function addCalendarComponentWithKeyAndValue($component,
                                                        $keyword,
                                                        $value)
    {
        if ($keyword == false) {
            $keyword = $this->last_keyword;
            switch ($component) {
                case 'VEVENT':
                    $value = $this->cal[$component][$this->event_count - 1]
                    [$keyword].$value;
                    break;
                case 'VTODO' :
                    $value = $this->cal[$component][$this->todo_count - 1]
                    [$keyword].$value;
                    break;
            }
        }

        if (stristr($keyword, "DTSTART") or stristr($keyword, "DTEND")) {
            $keyword = explode(";", $keyword);
            $keyword = $keyword[0];
        }

        switch ($component) {
            case "VTODO":
                $this->cal[$component][$this->todo_count - 1][$keyword] = $value;
                //$this->cal[$component][$this->todo_count]['Unix'] = $unixtime;
                break;
            case "VEVENT":
                $this->cal[$component][$this->event_count - 1][$keyword] = $value;
                break;
            default:
                $this->cal[$component][$keyword] = $value;
                break;
        }
        $this->last_keyword = $keyword;
    }

    /**
     * Get a key-value pair of a string.
     *
     * @param {string} $text which is like "VCALENDAR:Begin" or "LOCATION:"
     *
     * @return {array} array("VCALENDAR", "Begin")
     */
    public function keyValueFromString($text)
    {
        preg_match("/([^:]+)[:]([\w\W]*)/", $text, $matches);
        if (count($matches) == 0) {
            return false;
        }
        $matches = array_splice($matches, 1, 2);
        return $matches;
    }

    /**
     * Returns an array of arrays with all events. Every event is an associative
     * array and each property is an element it.
     *
     * @return {array}
     */
    public function events()
    {
        $array = $this->cal;
        return $array['VEVENT'];
    }

    /**
     * Returns a boolean value whether thr current calendar has events or not
     *
     * @return {boolean}
     */
    public function hasEvents()
    {
        return ( count($this->events()) > 0 ? true : false );
    }

    /**
     * Returns false when the current calendar has no events in range, else the
     * events.
     *
     * Note that this function makes use of a UNIX timestamp. This might be a
     * problem on January the 29th, 2038.
     * See http://en.wikipedia.org/wiki/Unix_time#Representing_the_number
     *
     * @param {boolean} $rangeStart Either true or false
     * @param {boolean} $rangeEnd   Either true or false
     *
     * @return {mixed}
     */
    public function eventsFromRange($rangeStart = false, $rangeEnd = false)
    {
        $events = $this->sortEventsWithOrder($this->events(), SORT_ASC);

        if (!$events) {
            return false;
        }

        $extendedEvents = array();

        if ($rangeStart !== false) {
            $rangeStart = new DateTime();
        }

        if ($rangeEnd !== false or $rangeEnd <= 0) {
            $rangeEnd = new DateTime('2038/01/18');
        } else {
            $rangeEnd = new DateTime($rangeEnd);
        }

        $rangeStart = $rangeStart->format('U');
        $rangeEnd   = $rangeEnd->format('U');



        // loop through all events by adding two new elements
        foreach ($events as $anEvent) {
            $timestamp = $this->iCalDateToUnixTimestamp($anEvent['DTSTART']);
            if ($timestamp >= $rangeStart && $timestamp <= $rangeEnd) {
                $extendedEvents[] = $anEvent;
            }
        }

        return $extendedEvents;
    }

    /**
     * Returns a boolean value whether thr current calendar has events or not
     *
     * @param {array} $events    An array with events.
     * @param {array} $sortOrder Either SORT_ASC, SORT_DESC, SORT_REGULAR,
     *                           SORT_NUMERIC, SORT_STRING
     *
     * @return {boolean}
     */
    public function sortEventsWithOrder($events, $sortOrder = SORT_ASC)
    {
        $extendedEvents = array();

        // loop through all events by adding two new elements
        foreach ($events as $anEvent) {
            if (!array_key_exists('UNIX_TIMESTAMP', $anEvent)) {
                $anEvent['UNIX_TIMESTAMP'] =
                    $this->iCalDateToUnixTimestamp($anEvent['DTSTART']);
            }

            if (!array_key_exists('REAL_DATETIME', $anEvent)) {
                $anEvent['REAL_DATETIME'] =
                    date("d.m.Y", $anEvent['UNIX_TIMESTAMP']);
            }

            $extendedEvents[] = $anEvent;
        }

        foreach ($extendedEvents as $key => $value) {
            $timestamp[$key] = $value['UNIX_TIMESTAMP'];
        }
        array_multisort($timestamp, $sortOrder, $extendedEvents);

        return $extendedEvents;
    }
}
?>