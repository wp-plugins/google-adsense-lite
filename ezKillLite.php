<?php

/*
  Copyright (C) 2008 www.ads-ez.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if (!function_exists('is_plugin_active')) {
  include_once ABSPATH . 'wp-admin/includes/plugin.php';
}

if (!class_exists('EzKillLite')) {

  class EzKillLite {

    var $lite, $pro, $killer;

    function __construct($lite, $pro, $killer) {
      $this->lite = $lite;
      $this->pro = $pro;
      $this->killer = $killer;
    }

    function EzKillLite($lite, $pro, $killer) {
      if (version_compare(PHP_VERSION, "5.0.0", "<")) {
        $this->__construct($lite, $pro, $killer);
        register_shutdown_function(array($this, "__destruct"));
      }
    }

    function init() {
      deactivate_plugins($this->lite);
    }

    function admin_footer() {
      printf('<script>document.getElementById("message").innerHTML="' . "<span style='font-weight:bold;font-size:1.1em;color:red'>{$this->killer}: " . __("Pro Plugin is activated. Lite version is deactivated.", "easy-common") . "</span>" . '";</script>');
    }

    function kill() {
      $killed = false;
      $proActive = is_plugin_active($this->pro);
      $liteActive = is_plugin_active($this->lite);
      if ($proActive && $liteActive) {
        add_action('init', array($this, 'init'));
        $plgPath = ABSPATH . PLUGINDIR . "/$this->lite";
        $liteData = get_plugin_data($plgPath);
        $plgPath = ABSPATH . PLUGINDIR . "/$this->pro";
        $proData = get_plugin_data($plgPath);
        printf('<div class="updated"><p>');
        printf(__("%s cannot be active now. Deactivating it so that you can use the Pro version %s If you really want to use the %s version, please deactivate the %s version first.", "easy-common"), "<strong><em>{$liteData['Name']}</em></strong>", "<strong><em>{$proData['Name']}</em></strong>.<br />", "<strong><em>Lite</em></strong>", "<strong><em>Pro</em></strong>");
        printf("<br /><strong>" . __("Please reload this page to remove stale links.", 'easy-common') . " <input type='button' value='Reload Page' onClick='window.location.href=window.location.href.replace(\"activate=true&\",\"\")'></strong>");
        printf('</p></div>');
        add_action('admin_footer-plugins.php', array($this, 'admin_footer'));
        $killed = true;
      }
      return $killed;
    }

  }

}

foreach ($liteList as $lite) {
  $ezKillLite = new EzKillLite($lite, $pro, $ezKillingPlg);
  if ($ezKillLite->kill()) {
    break;
  }
}