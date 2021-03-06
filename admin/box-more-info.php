<?php
$plgName = EzGA::getPlgName();
$plgSlug = EzGA::getSlug();
$plgPrice = EzGA::$plgPrice;
openBox("Upgrades");
if (EzGA::$isPro) {
  ?>
  <div class="col-sm-6 col-xs-12 goPro" data-product='ads-ez'>
    <a data-toggle="tooltip" title="Start your own ad server for only $20.95. Instant download. Fully compatible with Easy AdSense and AdSense Now! Serve and track ads to multiple blogs and websites." class="well top-block goPro" href="http://buy.thulasidas.com/ads-ez" data-product='ads-ez'>
      <i class="glyphicon glyphicon-shopping-cart red center-text"></i>
      <div>Get Ads EZ Pro &nbsp;&nbsp;<span class='label label-info moreInfo'>More Info</span></div>
      <div>$20.95. Instant Download</div>
    </a>
  </div>
  <?php
}
else {
  $proName = EzGA::getProName();
  ?>
  <div class="col-sm-6 col-xs-12 goPro" data-product="<?php echo $plgSlug; ?>">
    <a data-toggle="tooltip" title="Get <?php echo $proName; ?> for only $<?php echo $plgPrice[$plgSlug]; ?>. Tons of extra features. Instant download." class="well top-block goPro" href="http://buy.thulasidas.com/<?php echo $plgSlug; ?>">
      <i class="glyphicon glyphicon-shopping-cart red"></i>
      <div>Get <?php echo $proName; ?></div>
      <div>$<?php echo $plgPrice[$plgSlug]; ?>. Instant Download</div>
      <span class="notification red">Pro</span>
    </a>
  </div>
  <?php
}
?>
<div class="col-sm-6 col-xs-12">
  <a data-toggle="tooltip" title="See other premium WordPress plugins and PHP programs by the same author." class="well top-block" href="http://www.thulasidas.com/render" target="_blank">
    <i class="glyphicon glyphicon-star green"></i>
    <div>Other Plugins and Programs</div>
    <div>From the author</div>
  </a>
</div>
<div class="clearfix"></div>
<script>
  $(".moreInfo").click(function () {
    var product = $(this).parent().closest('a').attr('data-product');
    ezPopUp("http://www.thulasidas.com/" + product, product, 1000, 1024);
    return false;
  });
</script>
<?php
closeBox();
