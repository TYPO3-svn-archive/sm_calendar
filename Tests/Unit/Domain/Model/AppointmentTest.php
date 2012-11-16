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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_SmCalendar_Domain_Model_Appointment.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage SM - Calendar
 *
 */
class Tx_SmCalendar_Domain_Model_AppointmentTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_SmCalendar_Domain_Model_Appointment
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_SmCalendar_Domain_Model_Appointment();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getCalendarDateReturnsInitialValueForDateTime() { }

	/**
	 * @test
	 */
	public function setCalendarDateForDateTimeSetsCalendarDate() { }
	
	/**
	 * @test
	 */
	public function getStartTimeReturnsInitialValueForInt() { }

	/**
	 * @test
	 */
	public function setStartTimeForIntSetsStartTime() { }
	
	/**
	 * @test
	 */
	public function getEndTimeReturnsInitialValueForInt() { }

	/**
	 * @test
	 */
	public function setEndTimeForIntSetsEndTime() { }
	
	/**
	 * @test
	 */
	public function getLocationReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setLocationForStringSetsLocation() { 
		$this->fixture->setLocation('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getLocation()
		);
	}
	
	/**
	 * @test
	 */
	public function getDescriptionReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setDescriptionForStringSetsDescription() { 
		$this->fixture->setDescription('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getDescription()
		);
	}
	
	/**
	 * @test
	 */
	public function getCalendarReturnsInitialValueForTx_SmCalendar_Domain_Model_Calendar() { }

	/**
	 * @test
	 */
	public function setCalendarForTx_SmCalendar_Domain_Model_CalendarSetsCalendar() { }
	
}
?>