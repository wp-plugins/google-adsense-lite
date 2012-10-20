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

$ezErrorMsg = "" ;
$phpVersion = floatval(phpversion()) ;
$scriptName = strtolower(basename(dirname($_SERVER['SCRIPT_FILENAME'])));
if ($phpVersion < 5.0) {
  $ezErrorMsg = "<b><em>$scriptName</em></b>: " .
                "Your PHP version (" . $phpVersion . ") is too old. This plugin " .
                "needs version 5.3+. Please get your contact your web-hosting " .
                "support to upgrade your PHP version, or consider the " .
                "<a href='http://www.thulasidas.com/plugins/easy-adsense/' " .
                "target='_blank'><em>Easy AdSense</em></a> or <a " .
                "href='http://www.thulasidas.com/plugins/adsense-now/' " .
                "target='_blank'><em>AdSense Now!</em></a> plugin.<br/>" ;
}
if (!empty($ezErrorMsg)) {
  exit($ezErrorMsg) ;
}
?>
