<?php

    /**
     * This class is a demo view helper for the Fluid templating engine.
     *
     * @package TYPO3
     * @subpackage Fluid
     * @version
     */
class Tx_SmCalendar_ViewHelpers_CalendarListPerspectiveViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    /**
     * Renders some classic dummy content: Lorem Ipsum...
     *
     * @param array $$preRenderContent
     * @return string dummy content, cropped after the given number of characters
     *
     */
    public function render($preRenderContent) {
        $content = '<div style="padding-left: 20px;">';
        $i = 0;
        foreach ($preRenderContent as $entry){
            if ($entry['skip'] || !$entry['appointments']){
                continue;
            }
            $content .= '<span class="';
            if ($entry['today']){
                $content .= 'today';
            }
            $content .= '">'.$entry['day'].'.'.ltrim($entry['month'], 0).'</span><br/>';
            foreach($entry['appointments'] as $appointment){
                $i++;
                $content .= '<p style="color:'.$appointment['color'].'" class="listEntry calendar_'.$appointment['calendar'].'">'.
                            $appointment['starttime'].'-'.$appointment['endtime'].' '.$appointment['SUMMARY'].', '.
                            '<a title="Auf Karte anzeigen" target="_blank" href="http://maps.google.de/maps?hl=de&q='.stripslashes($appointment['LOCATION']).'">'.stripslashes($appointment['LOCATION']).'</a>, '.$appointment['DESCRIPTION'].'</p>';
            }
        }
        if ($i == 0){
            $content .= 'Keine Termine in diesem Monat';
        }
        $content .= '</div>';
        return $content;
    }
}