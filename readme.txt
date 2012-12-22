=== Google AdSense ===
Contributors: manojtd
Donate link: http://buy.thulasidas.com/google-adsense
Tags: google adsense, adsense, adsense plugin, ads, advertising, income
Requires at least: 3.2
Tested up to: 3.5
Stable tag: 1.45
License: GPL2 or later

Google AdSense showcases Google ads on your blog, with full customization.

== Description ==

*Google AdSense* provides a streamlined interface to deploy Google ads on your blog. You can customize the colors and sizes of the ad blocks and activate them right from the plugin interface.

*Google AdSense* is a specialized version of [Easy Ads](http://buy.thulasidas.com/easy-ads/ "Manage multiple ad providers on your blog"), which lets you manage multiple ad providers in a neat, tabbed interface. It may be more appropriate than *Google AdSense* if you plan to use more than one ad provider.

= Features =
1. Tabbed and intuitive interface.
2. Rich display and alignment options.
3. Widgets for your sidebar.
4. Robust codebase and option/object models.
5. Control over the positioning and display of ad blocks in each post or page.
6. Customized Google interface with color pickers.

= Pro Version =

*Google AdSense* is the freely distributed version of a premium plugin. The [Pro version](http://buy.thulasidas.com/google-adsense "Pro version of the Google AdSense plugin for $5.95") gives you even more features.

1. A filter to ensure that your ads show only on those pages that seem to comply with Google AdSense (and other common provider) policies, which can be important since some comments may render your pages inconsistent with those policies.
2. It also lets you specify a list of computers where your ads will not be shown, in order to prevent accidental clicks on your own ads -- one of the main reasons AdSense bans you.
3. Also in the works for the Pro version is a compatibility mode, which solves the issue of the ad insertion messing up your page appearances when using some  themes.

The Pro version costs $5.95 and can be [purchased online](http://buy.thulasidas.com/google-adsense/ "Pro version of the Google AdSense plugin for $5.95") with instant download link.

= New in this release =

Bug fix.

== Upgrade Notice ==

= 1.45 =

Bug fix.

== Screenshots ==

1. *Google AdSense* "Overview" tab.
2. How to set the options for *Google AdSense*.

== Installation ==

The easiest way to install this plugin is to use the WordPress Admin interface. Go to your admin dashboard, find the "Plugins" menu, and click on "Add New". Find this plugin and click on "Install Now" and follow the WordPress instructions.

If you want to download it and manually install, you can again use the WordPress dashboard interface. First download the plugin zip file to your local computer. Then go to your admin dashboard, find the "Plugins" menu, and click on "Add New". After clicking on the "Add New" menu item as above, click on "Upload" (below the title "Install Plugins" near the top). Browse for your downloaded zip file, upload it and activate the plugin.

If you want to manually upload it using your ftp program, unzip the downloaded zip file and,
1. Upload the *Google AdSense* plugin (the whole folder) to the '/wp-content/plugins/' directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Go to the Settings -> *Google AdSense* and enter your user ID and options.

== Frequently Asked Questions ==

= How can I control the appearance of the ad blocks using CSS? =

All `<div>`s that *Google AdSense* creates have the class attribute `google-adsense`. Furthermore, they have class attributes like `google-adsense-top`, `google-adsense-bottom` etc., You can set the style for these classes in your theme `style.css` to control their appearance.

= Why does my code disappear when I switch to a new theme? =

*Google AdSense* stores the ad code and options in your database indexed by the theme name, so that if you set up the options for a particular theme, they persist even when you switch to another theme. If you ever switch back to an old theme, all your options will be reused without your worrying about it.

But this unfortunately means that you do have to set the code *once* whenever you switch to a new theme.

= Can I control how the ad blocks are formatted in each page? =

Yes! In *Google AdSense*, you have more options [through **custom fields**] to control ad blocks in individual posts/pages. Add custom fields with keys like **google-adsense-top, google-adsense-middle, google-adsense-bottom** and with values like **left, right, center** or **no** to have control how the ad blocks show up in each post or page. The value "**no**" suppresses all the ad blocks in the post or page for that provider.

= How do I report a bug or ask a question? =

Please report any problems, and share your thoughts and comments [at the plugin forum at WordPress](http://wordpress.org/tags/google-adsense-lite "Post comments/suggestions/bugs on the WordPress.org forum. [Requires login/registration]") Or send an [email to the plugin author](http://manoj.thulasidas.com/mail.shtml "Email the author").

== Change Log ==

* V1.45: Bug fix. [Dec 22, 2012]
* V1.44: Enforcing the Google policy on the number of ads, and making the pub-id entry flexible. [Nov 4, 2012]
* V1.43: Minor changes to validate the readme.txt. [Oct 21, 2012]
* V1.42: Minor changes to validate the readme.txt. [Oct 21, 2012]
* V1.41: Initial public release of the lite version. [Oct 21, 2012]
* V1.40: Admin interface modifications. [Sep 30, 2012]
* V1.31: Taking care of some debug notices from WordPress debug mode. [Aug 28, 2012]
* V1.30: Initial public listing at WordPress.org. [July 18, 2012]
* V1.20: Bug fixes, coding improvements. [Sep 9, 2011]
* V1.00: Initial release. [Nov 15, 2010]
