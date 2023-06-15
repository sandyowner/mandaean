<?php
function getTimeDifference($from,$to)
{
    $date1 = strtotime($from);
    $date2 = strtotime($to);
    
    $diff = abs($date2 - $date1);
    $years = floor($diff / (365*60*60*24));
    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));
    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
    
    return (($years*365*24*60) + ($months*30*24*60) + ($days*24*60) + ($hours*60) + $minutes);
}
?>