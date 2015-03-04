<?php

$ezOptions = array();
$ezOptions['userid'] = array('name' => __("Your AdSense Account Name", 'easy-ads'),
    'help' => __("Enter your AdSense Pub-ID. This is the account id that normally looks like <code>pub-xxxxxxxxxx</code>. You can enter it exacty as you see it, preferably by cutting and pasting.", 'easy-ads'),
    'noCenter' => true,
    'value' => "Your AdSense ID");
$ezOptions['channel'] = array('name' => __("AdSense Channel", 'easy-ads'),
    'help' => "Enter your AdSense Channel, if you would like to track the earnings from this ad campgaign. Please visit Google to know more about setting up channels.",
    'noCenter' => true,
    'value' => "AdSense Default");
$ezOptions['format'] = array('name' => __('Format', 'easy-ads'),
    'help' => __('Choose the Format. The drop-down menu lists all possible ad formats that can be generated. Select the one that best suits your blog theme. All ads in the blog posts/pages will have the same format.', 'easy-ads'),
    'value' => "300x250",
    'noCenter' => true,
    'type' => 'select',
    'options' => array("234x60", "468x60", "728x90", "120x600", "160x600", "120x240",
        "125x125", "180x150", "468x15", "728x15", "160x90", "200x200", "300x250",
        "336x280", "250x250", "120x90", "180x90", "200x90"));
$ezOptions['type'] = array('name' => __('Type', 'easy-ads'),
    'help' => __('Type option is not fully implemented yet. You can select text only, images only, or text and images. Please visit Google for more information.', 'easy-ads'),
    'value' => 'image',
    'noCenter' => true,
    'type' => 'select',
    'options' => array('text' => __("Text Ad", 'easy-ads'),
        'image' => __("Image Ad", 'easy-ads'),
        'text_image' => __("Text and Image", 'easy-ads')));
$ezOptions['corners'] = array('name' => __('Corner Style', 'easy-ads'),
    'help' => __('Google lets you choose normal (square) corners or rounded ones. Enter your preference here.', 'easy-ads'),
    'value' => 'rc:0',
    'noCenter' => true,
    'type' => 'select',
    'options' => array(
        'rc:0' => __("Normal", 'easy-ads'),
        'rc:6' => __("Rounded", 'easy-ads')));

$ezOptions['widget'] = array('name' => __("Enable Widget", 'easy-ads'),
    'help' => sprintf(__('Enable widgets for %s', 'easy-ads'), "Google AdSense"),
    'value' => 1,
    'type' => 'checkbox');
$ezOptions['widgetformat'] = array('name' => __("Widget Format", 'easy-ads'),
    'help' => __('Choose the Format (size)', 'easy-ads'),
    'value' => "160x600",
    'type' => 'select',
    'options' => array("234x60", "468x60", "728x90", "120x600", "160x600", "120x240",
        "125x125", "180x150", "468x15", "728x15", "160x90", "200x200", "300x250",
        "336x280", "250x250", "120x90", "180x90", "200x90"));
$ezOptions['title_widget'] = array('name' => __('Widget Title', 'easy-adsenser'),
    'dataTpl' => "data-tpl='<input type=\"text\" style=\"width:230px\">'",
    'value' => 'Sponsored Links',
    'help' => __('Give a title to your widget -- something like Sponsored Links or Advertisements would be good. You can also suppress the title by checking the box to the right.', 'easy-adsenser'));

$ezOptions['linkcolor'] = array('name' => __("Link color", 'easy-ads'),
    'help' => __("Color of the headline, which introduces the listing, and hyperlinks to the relevant site.", 'easy-ads'),
    'value' => "164675",
    'type' => 'colorpicker');
$ezOptions['urlcolor'] = array('name' => __("URL color", 'easy-ads'),
    'help' => __("Color for the display URL, which is often an abbreviated URL in the same domain as the link URL contained in the headline", 'easy-ads'),
    'value' => "2666F5",
    'type' => 'colorpicker');
$ezOptions['textcolor'] = array('name' => __("Text color", 'easy-ads'),
    'help' => __("Color for the description lines, providing additional information and spanning multiple lines.", 'easy-ads'),
    'value' => "333333",
    'type' => 'colorpicker');
$ezOptions['bgcolor'] = array('name' => __("Background color", 'easy-ads'),
    'help' => __("Background color of your ad units. Select one that matches or contrasts your blog, according to your preference.", 'easy-ads'),
    'value' => "FFFFFF",
    'type' => 'colorpicker');
$ezOptions['bordercolor'] = array('name' => __("Border color", 'easy-ads'),
    'help' => __("Border color of your ad units. Select one that matches or contrasts your blog, according to your preference.", 'easy-ads'),
    'value' => "B0C9EB",
    'type' => 'colorpicker');

require 'box-ad-alignment-options.php';
require 'box-suppressing-ads-options.php';
require 'pro-options.php';
