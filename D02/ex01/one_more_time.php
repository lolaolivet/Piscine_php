#!/usr/bin/php
<?php
date_default_timezone_set('Europe/Paris');
$str = explode(" ", $argv[1]);
$i = 0;
foreach ($str as $e)
{
    if ($e)
        $i++;
}
if ($i == 5 && preg_match("/((l|L)undi)|((m|M)ardi)|((m|M)ercredi)|((j|J)eudi)|((v|V)endredi)|((s|S)amedi)|((d|D)imanche)/", "$str[0]")
    && ($str[1] > 0 || $str[1] < 31) && preg_match("/([01]?\d|2[0-3]):([0-5]\d):([0-5]\d)/", $str[4])){
    $h = explode(":", $str[4]);
    $months_num = ["janvier" => 01, "fevrier" => 02, "février" => 02, "mars" => 03, "avril" => 04, "mai" => 05,
        "juin" => 06, "juillet" => 07, "aout" => 8, "septembre" => 9, "octobre" => 10,
        "novembre" => 11, "decembre" => 12];
    $m = $months_num[strtolower($str[2])];
    $days = ["Monday" => "lundi",
        "Tuesday" => "mardi",
        "Wednesday" => "mercredi",
        "Thursday" => "jeudi",
        "Friday" => "vendredi",
        "Saturday", "samedi",
        "Sunday" => "dimanche"];
    $d = date("l", mktime($h[0], $h[1], $h[2], $m, $str[1], $str[3]));
    $dlow = strtolower($str[0]);
    if ($days["$d"] == $dlow) {
        $months = ["janvier" => "january", "fevrier" => "february", "février" => "february", "mars" => "march", "avril" => "april", "mai" => "may",
            "juin" => "june", "juillet" => "july", "aout" => "august", "septembre" => "september", "octobre" => "october",
            "novembre" => "november", "decembre" => "december"];
        $mlow = strtolower($str[2]);
        $mon = $months["$mlow"];
        echo strtotime("$str[1] $mon $str[3] $str[4]"), "\n";
    }
    else
        echo "Wrong Format\n";
}
else
    echo "Wrong Format\n";
?>