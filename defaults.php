<?php

/*
  Copyright (C) 2008 www.ads-ez.com

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License as
  published by the Free Software Foundation; either version 3 of the
  License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$plugindir = $this->URL;
$defaults = array
    (
    "defaultText" => "Please generate and paste your ad code here.",
    "tabs" =>
    array(
        "AdSense" =>
        array(
            "desc" => "The gold standard of web advertising, Google AdSense is what all other providers are measured against. Visit <a href='http://adsense.google.com' target='_blank'>Google AdSense</a> to sign up and generate ads.",
            "referral" => "<a href='http://adsense.google.com' target='_blank' title='Google AdSense'><img src='$plugindir/adsense.gif' border='0px' alt='[AdSense]' /></a>",
        ),
    ),
);
