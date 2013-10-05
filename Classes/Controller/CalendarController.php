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

require_once(t3lib_extMgm::extPath('sm_calendar') .'Classes/Service/Ical.php' );
require_once(t3lib_extMgm::extPath('sm_calendar') .'Classes/Service/DateCalculation.php' );

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
        $time = strtotime($dateParts[1]."-".$dateParts[0].'-01');
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
		$entries = array();
		foreach ($calendars as $calendar){
			/* @var Tx_SmCalendar_Domain_Model_Calendar $calender */
			$entries = array_merge($entries, $calendar->getEntries($displaydate));
		}
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
     * @todo -> VIEW
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

    /**
     * @param $color
     * @return array|boolean
     */
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
            $unixTimeStampStart = dateCalculation::iCalDateToUnixTimestamp($entry['DTSTART']);
            $day = date("j",$unixTimeStampStart);
            $adjust = 2;
			if ('0' === date("I",$unixTimeStampStart)){
				$adjust = 1;
			}
			$startHour = date("H",$unixTimeStampStart)+$adjust;
			$entry['starttime'] = $startHour.':'.date("i",$unixTimeStampStart);

            $unixTimeStampEnd = dateCalculation::iCalDateToUnixTimestamp($entry['DTEND']);
			if ('0' === date("I",$unixTimeStampEnd)){
				$adjust = 1;
			}
			$endHour = date("H",$unixTimeStampEnd)+$adjust;
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
}

?>