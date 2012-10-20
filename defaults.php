<?php
$plugindir = get_option('siteurl') . '/' . PLUGINDIR . '/' .  basename(dirname(__FILE__)) ;
$defaults = array
  (
  "ads" =>
  array (
    "hay" =>
    array (),
    "sizes" =>
    array (
      0 => "120x600",
      1 => "160x160",
      2 => "160x600",
      3 => "180x150",
      4 => "180x300",
      5 => "200x200",
      6 => "250x250",
      7 => "300x125",
      8 => "300x150",
      9 => "300x250",
      10 => "300x70",
      11 => "334x100",
      12 => "336x160",
      13 => "336x280",
      14 => "400x90",
      15 => "430x90",
      16 => "450x90",
      17 => "468x120",
      18 => "468x180",
      19 => "468x250",
      20 => "468x60",
      21 => "468x90",
      22 => "500x250",
      23 => "550x120",
      24 => "550x90",
      25 => "728x90",
           ),
         ),
  "defaultText" => "Please generate and paste your ad code here.",
  "banned" =>
  array (),
  "maxScore" => 0.4,
  "tabs" =>
  array (
    "AdSense" =>
    array (
      "desc" => "The gold standard of web advertising, Google AdSense is what all other providers are measured against. Visit <a href='http://adsense.google.com' target='_blank'>Google AdSense</a> to sign up and generate ads.",
      "referral" => "<a href='http://adsense.google.com' target='_blank' title='Google AdSense'><img src='$plugindir/adsense.gif' border='0px' alt='[AdSense]' /></a>",
           ),
         ),
   );
?>
