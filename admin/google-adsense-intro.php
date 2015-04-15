<div style="float:right;display:inline-block">
  <?php
  EzGA::showService();
  ?>
</div>
<h2>Ads EZ Plugin for Google AdSense<br>
  <small>Complete Control over Your AdSense Ads</small>
</h2>
<p><em>Ads EZ Plugin for Google AdSense</em> provides a very easy way to generate revenue from your blog using Google AdSense. With its full set of features, this Ads EZ plugin is perhaps the first plugin to give you a complete solution for everything AdSense-related.</p>

<p><strong>Google AdSense (AKA Ads EZ Plugin for Google AdSense)</strong>: This plugin is for the perfectionist in you, who would like to match the colors and sizes of your ad blocks to match and complement your theme. Here, the plugin takes over the task of generating the ad code. You just need to specify your <a href='https://support.google.com/adsense/answer/105516' target='_blank'class='popup'>publisher ID</a>.</p>

<p>
  <a class="btn btn-primary btn-help" data-toggle='tooltip' title="<p>View plugin features.<br>What can this plugin do?</p>" data-content="<p>Ads EZ Plugin for Google AdSense provides a streamlined interface to deploy Google ads on your blog. You can customize the colors and sizes of the ad blocks and activate them right from the plugin interface.</p><ol>
     <li>Tabbed and intuitive interface.</li>
     <li>Rich display and alignment options.</li>
     <li>Widgets for your sidebar.</li>
     <li>Robust codebase and option/object models.</li>
     <li>Control over the positioning and display of ad blocks in each post or page.</li>
     <li>Customized Google interface with color pickers.</li>
     <li>Available in your own language using machine translation curtsey of Google and Microsoft.</li>
     <li>Popover help for every option in the plugin.</li>
     <li>An interface tour to familiarize yourself with the plugin features and layout.</li>
     <li>Ability to spawn the plugin interface as a separate tab/window independent of the WordPress admin interface.</li>
     </ol>"><i class='glyphicon glyphicon-send'></i> Features</a>


  <a class="btn btn-primary btn-help" data-toggle='tooltip' title="<p>View Pro Features of this Plugin.<br>Why go Pro? You get all the basic features plus these!</p>" data-content="<p>In addition to the fully functional Lite version, there is a <a href='http://buy.thulasidas.com/google-adsense' title='Get Google AdSense Ultra for $9.45' class='goPro' data-product='google-adsense'>Pro Version</a> with many more features.</p>
     <p>If the following features are important to you, consider buying the <em>Pro</em> version.</p>
     <ol>
     <li>Safe Content filter: To ensure that your Google AdSense ads show only on those pages that seem to comply with Google AdSense policies, which can be important since some comments may render your pages inconsistent with those policies.</li>
     <li>IP filter: Ability to specify a list of computers where your ads will not be shown, in order to prevent accidental clicks on your own ads -- one of the main reasons AdSense bans you. These features will minimize your chance of getting banned.</li>
     <li>Compatibility mode: To solve the issue of the ad insertion messing up your page appearances when using some themes.</li>
     <li>Shortcode support: Show the ads only on the pages or posts you want, and exactly where you want them.</li>
     <li>Mobile support: Ability to serve mobile ads (or suppress ads) on mobile devices.</li>
     <li>Ability to show a configurable number of ads on Excerpts (which make up the home page in some themes).</li>
     <li>Multiple Sets of Options: You can create multiple sets of options, each applying to specific categories, posts or pages.</li>
     <li>Pause Ad Serving: Ability to temporarily suspend ads</li>
     <li>Statistics: Keep a tab on your ad provider by collecting statistics on your ad serving.</li>
     </ol><p><em><strong>Ads EZ Plugin for Google AdSense Ultra</strong></em> is the evolution of three wildly popular AdSense plugins: <strong>Easy AdSense</strong>, <strong>AdSense Now!</strong> and <strong>Google AdSense</strong>. It combines the features of all three of these plugins, and can operate as any one of them. For instance, if you choose the Easy AdSense mode, a menu item with the title Easy AdSense will appear which will take you to the familiar interface of that plugin.</p>
     <div class='center-block'><a class='btn btn-sm btn-danger goPro' href='http://buy.thulasidas.com/google-adsense' title='Get Google AdSense Ultra for $9.45' data-product='google-adsense'>Go Pro!</a></div>"><i class='glyphicon glyphicon-plane'></i> Pro Features</a>

  <a href='google-adsense-admin.php' class="btn btn-warning" data-toggle='tooltip' title="<p>Set up the plugin options and enter your AdSense code and details. You can also click on the <strong>Google AdSense</strong> tab above.</p>"><i class='glyphicon glyphicon-cog'></i> Setup Plugin</a>

  <a href='#' id='suspendAds' class="btn btn-danger" data-toggle='tooltip' title="<p>Pause ad serving.</p>"><i class='glyphicon glyphicon-pause'></i> Suspend Ads</a>

  <a href='#' id='resumeAds' style='display:none' class="btn btn-success" data-toggle='tooltip' title="<p>Resume ad serving.</p>"><i class='glyphicon glyphicon-play'></i> Resume Ads</a>

  <a href='#' id='migrateOptions' class="btn btn-success" data-toggle='tooltip' title="<p>This version of the plugin uses a new option model. If you used an older version before, your options are automatically imported when you activate the plugin. If you find them missing, please click this button to import them again. Note that your modified options are never overwritten by the migration process; so it is safe to run it again.</p>"><i class='glyphicon glyphicon-import'></i> Import Options</a>

</p>
<div class="clearfix"></div>
<script>
  $(document).ready(function () {
    $("#suspendAds").click(function () {
      suspendAds('suspend');
    });
    $("#resumeAds").click(function () {
      suspendAds('resume');
    });
    $("#migrateOptions").click(function (e) {
      e.preventDefault();
      var data = {};
      data.action = 'migrate';
      $.ajax({url: 'ajax/optionset.php',
        type: 'POST',
        data: data,
        success: function (a) {
          flashSuccess(a);
        },
        error: function (a) {
          showError(a.responseText);
        }});
    });
  });
</script>
