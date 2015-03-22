<?php

class GgAdSenseFront {

  var $leadin, $leadout, $options, $defaultText, $verbose = false;
  static $ezMax = 3, $ezCount = 0;
  static $filterPass = 0, $widgetCount = 0, $info;

  function GgAdSenseFront() {
    $optionSet = EzGA::getMobileType();
    if ($optionSet == "Killed") {
      EzGA::$noAdsReason .= 'Mobile Type says Killed. ';
      EzGA::$noAds = true;
      $optionSet = "";
    }
    $this->options = EzGA::getOptions($optionSet);
    $this->defaultText = $this->options['defaultText'];
    self::$info = EzGA::info();
    $this->verbose = !empty($this->options['verbose']);
  }

  function ezMax() {
    return self::$ezMax;
  }

  function ezCount() {
    return self::$ezCount;
  }

  function mkAdText($size = '') {
    $userid = trim(EzGA::$options['userid']);
    if (empty($userid) || $userid == "Your AdSense ID" || $userid == "Empty") {
      return EzGA::handleDefaultText('', $size);
    }
    if (strpos($userid, "pub") === false) {
      $userid = "pub-" . $userid;
    }
    if ($size == '') {
      $size = EzGA::$options['format'];
    }
    $x = strpos($size, 'x');
    $w = substr($size, 0, $x);
    $h = substr($size, $x + 1);
    $type = EzGA::$options['type'];
    $channel = EzGA::$options['channel'];
    $linkColor = EzGA::$options['linkcolor'];
    $urlColor = EzGA::$options['urlcolor'];
    $textColor = EzGA::$options['textcolor'];
    $bgColor = EzGA::$options['bgcolor'];
    $borderColor = EzGA::$options['bordercolor'];
    $corners = EzGA::$options['corners'];

    $adText = "<script type='text/javascript'><!--\n" .
            "google_ad_client = '$userid';\n" .
            "google_alternate_color = 'FFFFFF';\n" .
            "google_ad_width = $w;\n" .
            "google_ad_height = $h;\n" .
            "google_ad_format = '$size';\n" .
            "google_ad_type = '$type';\n" .
            "google_ad_channel ='$channel';\n" .
            "google_color_border = '$borderColor';\n" .
            "google_color_link = '$linkColor';\n" .
            "google_color_bg = '$bgColor';\n" .
            "google_color_text = '$textColor';\n" .
            "google_color_url = '$urlColor';\n" .
            "google_ui_features = '$corners';\n" .
            "//--></script>\n" .
            "<script type='text/javascript'\n" .
            "src='http://pagead2.googlesyndication.com/pagead/show_ads.js'>\n" .
            "</script>";
    return $adText;
  }

  function getStyle($show) {
    $lookup = array(
        "floatLeft" => 'float:left;',
        "left" => 'text-align:left;',
        "center" => 'text-align:center;',
        "floatRight" => 'float:right;',
        "right" => 'text-align:right;'
    );
    if (!empty($lookup[$show])) {
      return $lookup[$show];
    }
  }

  function mkAdBlock($slot, $format) {
    $adBlock = '';
    self::$ezCount++;
    if ($slot == 'widget') {
      self::$widgetCount++;
    }
    $adText = $this->mkAdText($format);
    if (!empty($adText)) {
      $show = EzGA::$metaOptions["show_$slot"];
      $css = $this->getStyle($show);
      $adBlock = "<div class='adsense adsense-$slot' style='{$css}margin:12px'>$adText</div>";
    }
    if ($this->verbose) {
      $info = self::$info;
      if (empty($adText)) {
        $adBlock = "\n$info\n<!-- Empty adText: Post[$slot] Count:" .
                self::$ezCount . " of " . self::$ezMax . "-->\n";
      }
      else {
        $adBlock = "\n$info\n<!-- Post[$slot] Count:" .
                self::$ezCount . " of " . self::$ezMax . "-->\n" .
                $adBlock . "\n$info\n";
        echo "\n$info\n <!--  ezCount = " . self::$ezCount . " - incremented at:\n";
        debug_print_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        echo "-->\n";
      }
    }
    $adBlock = stripslashes($adBlock);
    return $adBlock;
  }

  function resetFilter() {
    if (self::$filterPass > 1 && is_singular()) {
      self::$ezMax = $this->options['max_count'] - self::$widgetCount;
      self::$ezCount = self::$widgetCount;
      if ($this->verbose) {
        return " <!-- Filter Reset -->\n";
      }
    }
  }

  function filterContent($content) {
    ++self::$filterPass;
    $filterReset = $this->resetFilter();
    $plgName = EzGA::getPlgName();
    if ($this->verbose) {
      $content .= " <!-- $plgName: EzCount = " . self::$ezCount .
              " Filter Pass = " . self::$filterPass . "  -->\n";
      $content .= $filterReset;
    }
    $content = EzGA::preFilter($content);
    if (EzGA::$noAds) {
      return $content;
    }

    if (self::$ezCount >= self::$ezMax) {
      if ($this->verbose) {
        $content .= " <!-- $plgName: Unfiltered [count: " .
                self::$ezCount . " is not less than " . self::$ezMax . "] -->\n";
      }
      return $content;
    }

    $adMax = self::$ezMax;
    $adCount = 0;
    if (!is_singular()) {
      if (isset(EzGA::$options['excerptNumber'])) {
        $adMax = EzGA::$options['excerptNumber'];
      }
    }

    list($content, $return) = EzGA::filterShortCode($content);
    if ($return) {
      return $content;
    }

    $metaOptions = EzGA::getMetaOptions();
    $show_leadin = $metaOptions['show_top'];
    $leadin = '';
    if ($show_leadin != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $leadin = $this->mkAdBlock("top", $this->options['format']);
      }
    }

    $show_midtext = $metaOptions['show_middle'];
    $midtext = '';
    if ($show_midtext != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $midtext = $this->mkAdBlock("middle", $this->options['format']);
        if (!EzGA::$foundShortCode) {
          $paras = EzGA::findParas($content);
          $half = sizeof($paras);
          while (sizeof($paras) > $half) {
            array_pop($paras);
          }
          $split = 0;
          if (!empty($paras)) {
            $split = $paras[floor(sizeof($paras) / 2)];
          }
          $content = substr($content, 0, $split) . $midtext . substr($content, $split);
        }
      }
    }

    $show_leadout = $metaOptions['show_bottom'];
    $leadout = '';
    if ($show_leadout != 'no') {
      if (self::$ezCount < self::$ezMax && $adCount++ < $adMax) {
        $leadout = $this->mkAdBlock("bottom", $this->options['format']);
        if (!EzGA::$foundShortCode && strpos($show_leadout, "float") !== false) {
          $paras = EzGA::findParas($content);
          $split = array_pop($paras);
          if (!empty($split)) {
            $content1 = substr($content, 0, $split);
            $content2 = substr($content, $split);
          }
        }
      }
    }
    if (EzGA::$foundShortCode) {
      $content = EzGA::handleShortCode($content, $leadin, $midtext, $leadout);
    }
    else {
      if (empty($content1)) {
        $content = $leadin . $content . $leadout;
      }
      else {
        $content = $leadin . $content1 . $leadout . $content2;
      }
    }
    return $content;
  }

}

$ggAdSenseFront = new GgAdSenseFront();
if (!empty($ggAdSenseFront)) {
  add_filter('the_content', array($ggAdSenseFront, 'filterContent'));
  require_once 'google-adsense-widget.php';
  EzWidget::setPlugin($ggAdSenseFront);
  if (EzGA::isPro()) {
    if (!empty(EzGA::$options['enableShortCode'])) {
      $shortCodes = array('ezadsense', 'adsense');
      foreach ($shortCodes as $sc) {
        add_shortcode($sc, array('EzGA', 'processShortcode'));
      }
    }
  }
}
