<?php
/*
  Copyright (C) 2010 www.thulasidas.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or (at
  your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define('EZSIZE', '300x250') ;
if (!class_exists("ezExtras")) {
  class ezExtras { // static functions
    public static $defaults, $locale, $genOptionName, $genOptions, $b64 ;
    public static $isFiltered, $isPure, $gCount ;

    public static function getGScore($content){
      $banned = ezNS::$defaults['banned'] ;
      $content = strtolower(strip_tags($content));
      $str_word_count = str_word_count($content, 1) ;
      $bkeys = array_keys($banned) ;
      $intersect = array_intersect($str_word_count, $bkeys ) ;
      $words = array_count_values(array_intersect($str_word_count, $bkeys));

      $score = 0 ;
      foreach ($words as $word => $freq) {
        $score += $freq * $banned[$word] ;
      }
      if ($score > 0) {
        $wc =  str_word_count($content) ;
        if ($wc > 0) $score /= $wc*0.1 ;
      }
      return $score ;
    }
    public static function gFilter($content) {
      if (ezNS::$isFiltered) return ;
      ezNS::$isFiltered = true ;

      $locale = ezNS::$locale ;
      $isPure = strpos($locale, 'en_') == 0 ;
      if ($isPure) {
        $score = self::getGScore($content) ;
        $maxScore = (float) ezNS::$defaults['maxScore'] ;
          $isPure = $score < $maxScore ;
      }
      if ($isPure && ezNS::$genOptions['isPure'] != 'Yes') {
        ezNS::$genOptions['isPure'] = 'Yes' ;
        update_option(ezNS::$genOptionName, ezNS::$genOptions) ;
      }
      if (!$isPure && ezNS::$genOptions['isPure'] == 'Yes') {
        ezNS::$genOptions['isPure'] = 'No' ;
        update_option(ezNS::$genOptionName, ezNS::$genOptions) ;
      }
      ezNS::$isPure = $isPure ;
      return ;
    }
    public static function validSize($size) {
      $sizes = ezNS::$defaults['ads']['sizes'] ;
      if (in_array($size, $sizes)) return $size ;
      else return "300x250" ;
    }
    public static function splitSize($size) {
      $x = strpos($size, 'x') ;
      $w = substr($size, 0, $x);
      $h = substr($size, $x+1);
      $needle = array($w, $h) ;
      return $needle ;
    }
    public static function handleDefaultText($ad, $key = EZSIZE) {
      $ret = $ad ;
      if ($ret == ezNS::$defaults['defaultText'] || strlen(trim($ret)) == 0) {
        $x = strpos($key, 'x') ;
        $w = substr($key, 0, $x)-20;
        $h = substr($key, $x+1)-20;
        $p = (int)(min($w,$h)/6) ;
        $ret = '<div style="width:'.$w.'px;height:'.$h.'px;border:1px solid red;margin:10px;"><div style="padding:'.$p.'px;text-align:center;font-family:arial;font-size:8pt;"><p>Your ads will be inserted here by</p><p><b>'.ezNS::$name.'</b>.</p><p>Please go to the plugin admin page to paste your ad code.</p></div></div>' ;
      }
      return $ret ;
    }
    public static function decorateAd($ad) {
      return '<div class="easy-ads">' . $ad . "</div>\n" ;
    }
    public static function isGoogle($ad) {
      $isGoogle = strpos($ad, 'google_ad') !== FALSE ;
      return $isGoogle ;
    }
    public static function enforceGCount($ad) {
      $ret = $ad ;
      $isGoogle = self::isGoogle($ad) ;
      if ($isGoogle && ezNS::$gCount++ >= 3) {
        $ret = self::handleDefaultText('') ;
      }
      return self::decorateAd($ret) ;
    }
    public static function findPara($content, $midpoint) {
      $para = '<p' ;
      $content = strtolower($content) ;  // not using stripos() for PHP4 compatibility
      $paraPosition = strpos($content, $para, $midpoint) ;
      if ($paraPosition === FALSE) {
        $para = '<br' ;
        $paraPosition = strpos($content, $para, $midpoint) ;
      }
      return $paraPosition ;
    }
  } //End: Class ezExtras
}

?>
