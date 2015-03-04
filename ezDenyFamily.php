<?php

if (!empty($_REQUEST['action']) && $_REQUEST['action'] == 'activate') {
  if (!function_exists("ezDenyFamily")) {
    if (!function_exists('is_plugin_active')) {
      include_once ABSPATH . 'wp-admin/includes/plugin.php';
    }

    function ezDenyFamily($lite) {
      if (is_plugin_active($lite)) {
        add_action('init', function() {
          include_once ABSPATH . 'wp-admin/includes/plugin.php';
          deactivate_plugins($_REQUEST['plugin']);
        });
        $litePlg = ABSPATH . PLUGINDIR . "/" . $lite;
        $liteData = get_plugin_data($litePlg);
        $plg = $liteData['Name'];
        printf("<div class='error'>" . __("%s: Another plugin of the same family is active.<br />Please deactivate it before activating %s.", "easy-common") . "</div>", "<strong><em>$plg</em></strong>", "<strong><em>$plg</em></strong>");
        add_action('admin_footer-plugins.php', function() {
          $litePlg = ABSPATH . PLUGINDIR . "/" . $_REQUEST['plugin'];
          $liteData = get_plugin_data($litePlg);
          printf('<script>document.getElementById("message").innerHTML="' . "<span style='font-weight:bold;font-size:1.1em;color:red'>" . $liteData['Name'] . ": " . __("Cannot be activated!", "easy-common") . "</span>" . '";</script>');
        });
      }
    }

  }
  $family = array("google-adsense/google-adsense.php",
      "google-adsense-lite/google-adsense.php",
      "easy-adsense/easy-adsense.php",
      "easy-adsense-pro/easy-adsense.php",
      "easy-adsense-lite/easy-adsense.php",
      "easy-adsense-lite/easy-adsense-lite.php",
      "adsense-now/adsense-now.php",
      "adsense-now-pro/adsense-now.php",
      "adsense-now-lite/adsense-now.php",
      "adsense-now-lite/adsense-now-lite.php");
  $lite = $plg = "";
  foreach ($family as $lite) {
    ezDenyFamily($lite);
  }
}


else {
  $plugins = get_plugins();
  $ezPlugins = array(
      'adsense-now/adsense-now.php',
      'google-adsense/google-adsense.php',
      'google-adsense-lite/google-adsense.php',
      'easy-ads-lite/easy-ads.php',
      'easy-adsense/easy-adsense.php',
      'easy-ads/easy-ads.php',
      'easy-chitika-lite/easy-chitika.php',
      'easy-chitika/easy-chitika.php',
      'easy-adsense-lite/easy-adsense-lite.php',
      'google-adsense/google-adsense.php',
      'adsense-now-lite/adsense-now-lite.php'
  );
  $ezAdminNotice = '<ul>';
  foreach ($plugins as $k => $p) {
    if (is_plugin_active($p) && in_array($k, $ezPlugins)) {
      $ezAdminNotice .= "<li><code>$k</code>: {$p['Name']}</li>\n";
    }
  }
  $ezAdminNotice .= "</ul>";
  if ($ezAdminNotice != "<ul></ul>") {
    add_action('admin_notices', create_function('', 'global $ezAdminNotice; echo \'<div class="error"><p><b><em>Google AdSense</em></b>: Please have only one of these plugins active.</p>$ezAdminNotice</div>\';'));
  }
}