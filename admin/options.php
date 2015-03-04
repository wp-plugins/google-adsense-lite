<?php
if (file_exists("options-advanced.php")) {
  require_once "options-advanced.php";
  return;
}
require('header.php');
?>
<div>
  <ul class="breadcrumb">
    <li>
      <a href="#">Home</a>
    </li>
    <li>
      <a href="#">Configuration</a>
    </li>
  </ul>
</div>

<?php
openBox("Other Options", "th-list", 11, "The table below is editable. You can click on the option values and enter new values.  Hover over the <i class='glyphicon glyphicon-question-sign blue'></i> <b>Help</b> button on the row for quick info on what that option does.");
?>
<p>This feature is available in the <a href="#" class="goPro">Pro version</a> of this program, which allows you to backup and restore your database in a variety of ways.</p>
<p>In this lite version, you will have to use your favorite database tool, such as phpMyAdmin.</p>
<hr>
<h4>Screenshot of the DB Tools from the <a href="#" class="goPro">Pro</a> Version</h4>
<?php
showScreenshot(3);
?>
<div class="clearfix"></div>
<?php
closeBox();
include 'promo.php';
require('footer.php');
