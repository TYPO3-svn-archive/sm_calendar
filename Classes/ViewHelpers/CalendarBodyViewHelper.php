<?php

/**
 * This class is a demo view helper for the Fluid templating engine.
 *
 * @package TYPO3
 * @subpackage Fluid
 * @version
 */
class Tx_SmCalendar_ViewHelpers_CalendarBodyViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

    /**
     * Renders some classic dummy content: Lorem Ipsum...
     *
     * @param array $$preRenderContent
     * @return string dummy content, cropped after the given number of characters
     *
    */
    public function render($preRenderContent) {
        $i = 1;
        $content = '<tr>';
        foreach ($preRenderContent as $entry){
            $rest = $i%7;
            $content .= '<td';
            $even = array(2,4,6);
            $weekend = array(6,0);
            if (in_array($rest,$even)){
                if (in_array($rest, $weekend)){
                    $content .= ' class="even weekend">';
                } else {
                    $content .= ' class="even">';
                }
            } else {
                if (in_array($rest, $weekend)){
                    $content .= ' class="odd weekend">';
                } else {
                    $content .= ' class="odd">';
                }
            }
            $content .= '<span class="CalDay';
            if ($entry['today']){
                $content .= ' today';
            }
            $content .='">'.$entry['day'].'</span>';
            foreach ($entry['appointments'] as $appointment){
                $content .= '<p style="color:'.$appointment['color'].'" class="appointment calendar_'.$appointment['calendar'].'">'.$appointment['starttime'].' '.$appointment['SUMMARY'].'</p>'.
                            '<div class="tooltip">'.$appointment['starttime'].' - '.$appointment['endtime'].'<br/>'.$appointment['SUMMARY'].'<br/>'.
                            '<a title="Auf der Karte anzeigen" target="_blank" href="http://maps.google.de/maps?hl=de&q='.stripslashes($appointment['LOCATION']).'">'.stripslashes($appointment['LOCATION']).'</a><br/>'.
                            $appointment['DESCRIPTION'].'</div>';
            }
            $content .= '</td>';
            if ($rest === 0){
                $content .= '</tr><tr>';
            }
            $i++;
        }
        $content .= '</tr>';
        return $content;
    }
}
