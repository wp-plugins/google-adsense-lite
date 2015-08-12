<?php require 'header.php'; ?>
<div>
  <ul class="breadcrumb">
    <li>
      <a href="#">Home</a>
    </li>
    <li>
      <a href="#">Dashboard</a>
    </li>
  </ul>
</div>

<?php
require 'google-adsense-options.php';
insertAlerts();
?>
<div class="col-md-12">
  <?php
  openRow();
  openCell("Settings for your Google AdSense Plugin", 'cog', 7);
  ?>
  <p>To get started with this plugin, visit <a href='http://www.google.com/adsense' target='_blank' class='popup'>AdSense</a> page to sign up and get an account. Once you have the account details,  enter the publisher ID and other parameters needed for this plugin. Hovering over any input field will give you a short description and help about how to enter the information.</p>
  <p>This plugin, working in Google AdSense mode, will let you place up to three ad blocks in your pages and posts, and as many widgets as you like. The ad blocks will all share the same format (ad size) and colors. The same color scheme will apply to the widget as well, but its format (size) can be independently set. You do not have to cut and paste any ad code; the plugin will generate it for you from your <a href='https://support.google.com/adsense/answer/105516' target='_blank' class='popup'>publisher ID</a>.</p>
  <p>This plugin remembers your settings for each WordPress theme that you use. Currently, you are editing the settings for the theme <strong><code><?php echo $options['theme']; ?></code></strong>.</p>
  <?php
  closeCell();
  require 'box-optionset.php';
  closeRow();
  ?>
</div>
<div class="clearfix"></div>
<div id="left" class="col-md-6 col-sm-12 pull-left">
  <?php
  $keys = array('userid', 'channel', 'format', 'type', 'corners');
  openBox("AdSense Account and Ad Format");
  ?>
  <p>Enter your AdSense account details and ad format options below.</p>
  <?php
  foreach ($keys as $pk) {
    echo EzGA::renderOptionCell($pk, $ezOptions[$pk]);
  }
  closeBox();

  openBox("Widgets");
  $widgetURL = admin_url('widgets.php');
  echo "<p>"
  . sprintf(__('Go to %s to find and place this widget on your sidebar', 'easy-ads'), "<a href='$widgetURL' target='_parent'> " . __('Appearance', 'easy-ads') . ' &rarr; ' . __('Widgets', 'easy-ads') . "</a>")
  . "</p>";
  ?>
  <div class="col-md-3">
    <?php
    echo EzGA::renderOptionCell('widget', $ezOptions['widget']);
    ?>
  </div>
  <div class="col-md-3">
    <?php
    echo EzGA::renderOptionCell('widgetformat', $ezOptions['widgetformat']);
    ?>
  </div>
  <div class="col-md-6">
    <?php
    echo EzGA::renderOptionCell('title_widget', $ezOptions['title_widget']);
    ?>
  </div>
  <div class="clearfix"></div>
  <?php
  closeBox();
  require 'box-ad-alignment.php';
  ?>
</div>
<div id="right" class="col-md-6 col-sm-12">
  <?php
  $keys = array('linkcolor', 'urlcolor', 'textcolor', 'bgcolor', 'bordercolor');
  openBox("Ad Unit Colors");
  ?>
  <p>Select the ad colors to match your theme. You can enter the color by typing it in or by clicking on the color patch next to it input box, which will bring up a color picker.</p>
  <?php
  foreach ($keys as $pk) {
    echo EzGA::renderOptionCell($pk, $ezOptions[$pk]);
  }
  ?>
  <div class="clearfix"></div>
  <?php
  closeBox();
  require 'box-suppressing-ads.php';
  require 'box-more-info.php';
  ?>
</div>
<script>
  var xeditHandler = 'ajax/options.php';
  var xparams = {};
  xparams.plugin_slug = '<?php echo $options['plugin_slug']; ?>';
  xparams.theme = '<?php echo $options['theme']; ?>';
  xparams.provider = '<?php echo $options['provider']; ?>';
  xparams.optionset = '<?php echo $options['optionset']; ?>';
</script>
<?php
require_once 'footer.php';
