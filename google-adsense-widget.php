<?php

if (!class_exists("GgAdsWidget")) {
  require_once 'EzWidget.php';

  class GgAdsWidget extends EzWidget {

    function __construct() {
      parent::__construct("GgAdsWidget", "Google AdSense: Widget");
    }

    function getAdText() {
      $plg = self::$plg;
      if (empty($plg->options['widget'])) {
        return;
      }
      EzGA::preFilter("", true);
      if (EzGA::$noAds) {
        return;
      }
      $format = $plg->options['widgetformat'];
      $metaOptions = EzGA::getMetaOptions();
      EzGA::$metaOptions["show_widget"] = ""; // used in $plg->mkAdBlock
      $class = get_class($plg);
      if ($class::$ezCount < $class::$ezMax) {
        return $plg->mkAdBlock("widget", $format);
      }
    }

    function getTitle() {
      $plg = self::$plg;
      $title = stripslashes(htmlspecialchars($plg->options['title_widget']));
      return $title;
    }

    function decorate($adText) {
      if (!empty($adText)) {
        echo "<div class='adsense adsense-widget'>$adText</div>\n";
      }
    }

  }

  add_action('widgets_init', create_function('', 'return register_widget("GgAdsWidget");'));
}