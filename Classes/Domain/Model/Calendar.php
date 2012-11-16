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
class Tx_SmCalendar_Domain_Model_Calendar extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

    /**
     * addLink
     *
     * @var string
     */
    protected $addLink;

    /**
     * color
     *
     * @var string
     */
    protected $color;

    /**
     * iCalAddress
     *
     * @var string
     * @validate NotEmpty
     */
    protected $iCalAddress;

    /**
     * darkerColor
     *
     * @var string
     */
    protected $darkerColor;

    /**
     * Returns the darkerColor
     *
     * @return string $darkerColor
     */
    public function getDarkerColor() {
        return $this->darkerColor;
    }

    /**
     * Sets the darkerColor
     *
     * @param string $darkerColor
     * @return void
     */
    public function setDarkerColor($darkerColor) {
        $this->darkerColor = $darkerColor;
    }

    /**
     * Returns the color
     *
     * @return string $color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Sets the color
     *
     * @param string $color
     * @return void
     */
    public function setColor($color) {
        $this->color = $color;
    }

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle() {
        return $this->title;
    }

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

    /**
     * Returns the iCalAddress
     *
     * @return string $iCalAddress
     */
    public function getICalAddress() {
        return $this->iCalAddress;
    }

    /**
     * Sets the iCalAddress
     *
     * @param string $iCalAddress
     * @return void
     */
    public function setICalAddress($iCalAddress) {
        $this->iCalAddress = $iCalAddress;
    }

	/**
	 * Returns the addLink
	 *
	 * @return string $addLink
	 */
	public function getAddLink() {
		return $this->addLink;
	}

	/**
	 * Sets the addLink
	 *
	 * @param string $addLink
	 * @return void
	 */
	public function setAddLink($addLink) {
		$this->addLink = $addLink;
	}

}
?>