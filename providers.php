<?php
/*
  Copyright (C) 2010 www.thulasidas.com

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or (at
  your option) any later version.

  This program is distributed in the hope that it will be useful, but
  WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if (class_exists("provider")) {
//  echo "Class <code>'provider'</code> already defined.\nConsider using <code>Easy Ads</code> for multiple ad providers." ;
}
if (!class_exists("adBlock")) {
  class adBlock extends ezOption { // an ad block that will be displayed
    var $comment ;
    function __construct($name) {// constructior
      parent::ezOption('adBlock', $name) ;
    }
    function decorate() {// apply styles
      if (empty($this->style))
        $inline = '' ;
      else
        $inline = 'style="' . $this->style . '"' ;
      if (!empty($this->value))
        $this->value = '<div class="google-adsense google-adsense-' . strtolower($this->name)  . '" ' .
          $inline . '>' . $this->value . "</div>\n" ;
    }
  } // End: Class adBlock
}

if (!class_exists("provider")) {
  class provider extends ezTab {
    var $maxAds = 3 ;
    var $adBlocks = array() ; // ad blocks that will be injected by the content filter
    var $positions = array('top', 'middle', 'bottom') ;
    var $killOptions = array('page', 'home', 'attachment', 'front_page',
                 'category', 'tag', 'archive', 'feed') ;

    // function provider($name, $desc, $referral) {// constructor
    function __construct($name, $defaults) {// constructor
      parent::ezTab($name, $defaults) ;
    }
    function defineOptions() { // Add all options
      unset($this->options) ;
      $option = &$this->addOption('message', 'intro') ;
      $properties = array('desc' => "About " . $this->name,
         'before' => '<br /><table><tr><th colspan="3"><h4>',
          'after' => '</h4></th></tr><tr align="left" valign="middle"><td width="20%">') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'active') ;
      $properties = array('desc' => '&nbsp;' . 'Activate ' . $this->name . '?',
          'title' => "Check to activate " . $this->name,
          'value' => true,
         'before' => '',
          'after' => '<br />') ;
      $option->set($properties) ;

      $option = &$this->addOption('message', 'referral') ;
      $referral = '' ;
      if (!empty($this->referral)) $referral = htmlspecialchars_decode($this->referral) ;
      $properties = array('desc' => $referral,
         'before' => '</td><td width="20%">&nbsp;' ,
          'after' => '</td>') ;
      $option->set($properties) ;

      $option = &$this->addOption('message', 'info') ;
      $desc = '' ;
      if (!empty($this->desc)) $desc = htmlspecialchars_decode($this->desc) ;
      $properties = array('desc' => $desc,
         'before' => '<td >',
          'after' => '</td></tr></table><hr />');
      $option->set($properties) ;

      // >>> Mini Tab
      $miniTab = &$this->addOption('miniTab', 'textTab') ;
      $properties = array('desc' => 'Tabbie',
          'title' => " tab interface ",
          'value' => $this->name ,
         'before' => '<table><tr align="center" valign="top"><td width="50%"><br />',
          'after' => '</td>');
      $miniTab->set($properties) ;

      $mTab = &$miniTab->addTab('body') ;
      $properties = array('desc' => 'Body',
          'title' => " tab interface ",
          'value' => $this->name . 'body');
      $mTab->set($properties) ;

      $option = &$mTab->addTabOption('textarea', 'body') ;
      $properties = array('desc' => '<b>Enter your ' . $this->name . ' code here: </b>',
          'title' => 'Logon and generate advert code for ' . $this->name .
                    " and paste it in its entirity here. (When left empty and active, " .
                    "author's ads may be displayed.)",
          'value' => $this->plugin->defaults['defaultText'] ,
          'after' => '<br />');
      $option->set($properties) ;

      $mTab = &$miniTab->addTab('widget') ;
      $properties = array('desc' => 'Widget',
          'title' => "Enter your widget code here",
          'value' => $this->name . 'widget');
      $mTab->set($properties) ;

      $option = &$mTab->addTabOption('textarea', 'widget-text') ;
      $properties = array('desc' => '<b>Enter your side-bar widget code here: </b>',
          'title' => 'Logon and generate advert code for ' . $this->name .
                    " and paste it in its entirity here. (When left empty and active, " .
                    "author's ads may be displayed.)",
          'style' => "width: 96%; height: 140px;",
          'value' => $this->plugin->defaults['defaultText'] ,
          'after' => '<br />');
      $option->set($properties) ;

      $option = &$mTab->addTabOption('checkbox', 'widget') ;
      $properties = array('desc' => 'Enable widgets for ' . $this->name,
          'title' => "Widgets can be added from",
          'value' =>  true,
         'before' => '&nbsp;');
      $option->set($properties) ;

      $msg = &$mTab->addTabOption('message', 'widgetLink') ;
      $properties = array('desc' => 'Go to <a href="widgets.php"> Appearance &rarr; Widgets</a> to find <br /> and place this widget on your sidebar',
                    'before' => '<br >',
                    'after' => '<br />') ;
      $msg->set($properties) ;


      // <<< end Mini Tab

      $option = &$this->addOption('message', 'alignment') ;
      $properties = array(
        'desc' => "<b>Ad Alignment. Where to show ad blocks?</b>",
        'before' => '<td><table><tr align="center" valign="middle"><th colspan="5">',
        'after' => "</th></tr>\n" . '<tr align="center" valign="middle">' .
        '<td>&nbsp;</td><td>&nbsp;Align Left&nbsp;</td><td>&nbsp;Center&nbsp;</td>' .
        '<td>&nbsp;Align Right&nbsp;</td><td>&nbsp;Suppress&nbsp;</td></tr>');
      $option->set($properties) ;

      // >>> Radiobox
      $radio = &$this->addOption('radio', 'show_top') ;
      $properties = array('desc' => 'Top',
          'title' => 'Where to show the top ad block?',
          'value' => "left",
         'before' => '<tr align="center" valign="middle"><td>Top</td>',
          'after' => '</tr>') ;
      $radio->set($properties) ;

      $choice = &$radio->addChoice('left') ;
      $properties = array('value' =>"left",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('center') ;
      $properties = array('value' =>"center",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('right') ;
      $properties = array('value' =>"right",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('no') ;
      $properties = array('value' =>"no",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;
      // <<< end  Radiobox

      // >>> Radiobox
      $radio = &$this->addOption('radio', 'show_middle') ;
      $properties = array('desc' => 'Middle',
          'title' => 'Where to show the mid-text ad block?',
          'value' => "left",
         'before' => '<tr align="center" valign="middle"><td>Middle</td>',
          'after' => '</tr>') ;
      $radio->set($properties) ;

      $choice = &$radio->addChoice('left') ;
      $properties = array('value' =>"left",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('center') ;
      $properties = array('value' =>"center",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('right') ;
      $properties = array('value' =>"right",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('no') ;
      $properties = array('value' =>"no",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;
      // <<< end  Radiobox

      // >>> Radiobox
      $radio = &$this->addOption('radio', 'show_bottom') ;
      $properties = array('desc' => 'Bottom',
          'title' => 'Where to show the bottom ad block?',
          'value' => "right",
          'after' => '<br />',
         'before' => '<tr align="center" valign="middle"><td>Bottom</td>',
          'after' => '</tr></table>') ;
      $radio->set($properties) ;

      $choice = &$radio->addChoice('left') ;
      $properties = array('value' =>"left",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('center') ;
      $properties = array('value' =>"center",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('right') ;
      $properties = array('value' =>"right",
         'before' => '<td>',
          'after' => '</td>') ;
      $choice->set($properties) ;

      $choice = &$radio->addChoice('no') ;
      $properties = array('value' =>"no",
         'before' => '<td>' ,
          'after' => '</td>') ;
      $choice->set($properties) ;
      // <<< end  Radiobox

      // >>> Radiobox
      $option = &$this->addOption('message', 'show_or_hide') ;
      $properties = array(
        'desc' => "<b>Suppress Ad Blocks in:&nbsp;&nbsp;</b>",
        'before' => '<table><tr align="center" valign="middle"><td>',
        'after' => '</td><td></td></tr>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_feed') ;
      $properties = array('desc' =>
                    'RSS feeds',
          'title' => "RSS feeds from your blog",
          'value' =>  true,
         'before' => '<tr><td>&nbsp;',
          'after' => '</td>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_page') ;
      $properties = array('desc' =>
                    '<a href="http://codex.wordpress.org/Pages" target="_blank" ' .
                    'title=" Click to see the difference between posts and pages">' .
                    'Static Pages</a>',
          'title' => "Ads appear only on blog posts, not on blog pages",
          'value' =>  true,
         'before' => '<td>&nbsp;',
          'after' => '</td></tr>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_home') ;
      $properties = array('desc' => "Home Page",
          'title' => "Home Page and Front Page are the same for most blogs",
          'value' => true,
         'before' => '<tr><td>&nbsp;' ,
          'after' => '</td>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_front_page') ;
      $properties = array('desc' => "Front Page",
          'title' => "Home Page and Front Page are the same for most blogs",
          'value' => true,
         'before' => '<td>&nbsp;' ,
          'after' => '</td></tr>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_attachment') ;
      $properties = array('desc' => "Attachment Page",
          'title' => "Pages that show attachments",
          'value' => true,
         'before' => '<tr><td>&nbsp;' ,
          'after' => '</td>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_category') ;
      $properties = array('desc' => "Category Pages",
          'title' => "Pages that come up when you click on category names",
          'value' => true,
         'before' => '<td>&nbsp;' ,
          'after' => '</td></tr>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_tag') ;
      $properties = array('desc' => "Tag Pages",
          'title' => "Pages that come up when you click on tag names",
          'value' => true,
         'before' => '<tr><td>&nbsp;' ,
          'after' => '</td>') ;
      $option->set($properties) ;

      $option = &$this->addOption('checkbox', 'kill_archive') ;
      $properties = array('desc' => "Archive Pages",
          'title' => "Pages that come up when you click on year/month archives",
          'value' => true,
         'before' => '<td>&nbsp;' ,
          'after' => '</td></tr></table></td></tr></table>') ;
      $option->set($properties) ;
    }

    function defineSubmitButtons() { // Add submit buttons
      parent::defineSubmitButtons() ;

      $button = &$this->addSubmitButton('submit', 'update') ;
      $properties = array('value' => 'Save Changes',
          'title' => "Save the changes as specified above.");
      $button->set($properties) ;

      $button = &$this->addSubmitButton('submit', 'reset') ;
      $properties = array('value' => 'Reset Options',
          'title' => 'DANGER: Reset all ' . $this->name . ' options to default.');
      $button->set($properties) ;

      $button = &$this->addSubmitButton('submit', 'clean_db') ;
      $properties = array('value' => 'Clean Database',
          'title' => 'DANGER: Delete all ' . $this->name . ' options from the database.');
      $button->set($properties) ;
    }
    function renderContent() {
      $name = $this->name ;
      echo '<h3>Options for ', $name, "</h3>\n" ;
    }
    // ------------ Widget handling ----------------
    function buildWidget() {
      if ($this->isActive && $this->get('widget')){
        $widgetClass = ezNS::ns($this->name . 'Widget') ;
        if (!class_exists($widgetClass)) $widgetClass = 'providerWidget' ;
        eval($widgetClass . '::setProvider(&$this) ;') ;
        add_action('widgets_init',
                   create_function('', 'return register_widget("' . $widgetClass . '");'));
      }
    }
    // ------------ Content Filter -----------------
    function buildAdBlocks() {
      if (!$this->checkDependencyInjection(__FUNCTION__)) return ;
      if ($this->isActive) {
        foreach ($this->plugin->positions as $key) {
          $name = $this->name . '-' . $key ;
          $this->adBlocks[$key] =& new adBlock($name) ;
          $adText = stripslashes($this->get('body')) ; // The option will be called 'body-'.$key
          $adText = ezExtras::handleDefaultText($adText) ;
          $this->adBlocks[$key]->set($adText) ;
        }
      }
    }
    function applyAdminOptions() { // From option values to inline style strings
      if (!$this->checkDependencyInjection(__FUNCTION__)) return ;
      if ($this->isActive) {
        foreach ($this->plugin->positions as $key) {
          $adBlock =& $this->adBlocks[$key] ;
          $showKey = 'show_' . $key ;
          $alignment = $this->options[$showKey]->get() ;
          if ($alignment == 'no') {
            $name = $this->name ;
            $emptyText = "\n<!-- Google AdSense: Suppressed $name by $showKey option -->\n" ;
            $adBlock->set($emptyText) ;
          }
          else {
            if ($alignment == 'left')
              $style = 'float:left;display:block;' ;
            if ($alignment == 'right')
              $style = 'float:right;display:block;' ;
            if ($alignment == 'center')
              $style = 'display:block;text-align:center;' ;
            if (!empty($style)) {
              $properties = array() ;
              $properties['style'] = $style ;
              $adBlock->set($properties) ;
            }
          }
        }
      }
    }
    function applyMetaOptions() { // Read options given as post meta tags.
      // Post meta options are of the kind:
      //   key = provider name, pname-top, pname-bottom, pname-widget etc
      //   value = no, left, right, center etc.
      // Example: adsense => no, adsense-bottom => left etc
      if (!$this->checkDependencyInjection(__FUNCTION__)) return ;
      if ($this->isActive) {
        global $post;
        $metaKey = strtolower($this->name) ;
        $customStyle = get_post_custom_values($metaKey, $post->ID, true);
        if (is_array($customStyle)){
          $metaStyle = strtolower($customStyle[0]) ;
        }
        else
          $metaStyle = strtolower($customStyle) ;
        if ($metaStyle == 'no') {
          foreach ($this->plugin->positions as $key) {
            $emptyText = "\n<!-- Google AdSense: Suppressed $key by custom tag: $metaKey -->\n" ;
            $this->adBlocks[$key]->set($emptyText) ;
          }
          return ;
        }
        foreach ($this->plugin->positions as $key) {
          $metaKey = $this->name . '-' . $key ;
          $customStyle = get_post_custom_values($metaKey, $post->ID, true);
          if (is_array($customStyle))
            $metaStyle = strtolower($customStyle[0]) ;
          else
            $metaStyle = strtolower($customStyle) ;

          if ($metaStyle == 'left')
            $style = 'float:left;display:block;' ;
          if ($metaStyle == 'right')
            $style = 'float:right;display:block;' ;
          if ($metaStyle == 'center')
            // $style = 'margin-left:atuo;margin-right:auto;' ;
            $style = 'text-align:center;display:block;' ;
          if ($metaStyle == 'no'){
            $emptyText = "\n<!-- Google AdSense: Suppressed $key by custom tag: $metaKey -->\n" ;
            $this->adBlocks[$key]->set($emptyText) ;
          }
          if (!empty($style)) {
            $properties = array() ;
            $properties['style'] = $style ;
            $this->adBlocks[$key]->set($properties) ;
          }
        }
      }
    }
    function decorateAdBlocks() { // From option values to inline style strings
      if (!$this->checkDependencyInjection(__FUNCTION__)) return ;
      if ($this->isActive) {
        foreach ($this->plugin->positions as $key) {
          $this->adBlocks[$key]->decorate() ;
        }
      }
    }
    function buildAdStacks() {
      if (!$this->checkDependencyInjection(__FUNCTION__)) return ;
      if ($this->isActive) {
        foreach ($this->killOptions as $k) {
          $fn = 'is_' . $k ;
          $key = 'kill_' . $k ;
          if (function_exists($fn)) {
            if ($this->options[$key]->get() && $fn()) return ;
          }
          else {
            $errorMessage = '<div style="background-color:#fdd;border: solid 1px #f00; ' .
              'padding:5px"><p><b><em>ezAPI</em></b>: ' . $this->name .
              ": Unknown function ($fn) requested in <code>" . __FUNCTION__ . "</code>.</p></div>\n" ;
            echo $errorMessage ;
          }
        }
        $this->applyMetaOptions() ; // meta options are defined only within the Loop
        $this->decorateAdBlocks() ;
        // build an ad stack each per position (top, middle, bottom)
        foreach ($this->plugin->positions as $k) {
          array_push(&$this->plugin->adArrays[$k], $this->adBlocks[$k]->get()) ;
        }
      }
    }
  } // End: Class provider
}

if (!class_exists("providerWidget")) {
  class providerWidget extends WP_Widget {
    var $name ;
    public static $provider ;
    function providerWidget($name = 'providerWidget', $provider = '') {
      if ($provider == '') $provider = self::$provider ;
      $this->name = $name ;
      $widget_ops = array('classname' => 'providerWidget',
                    'description' => 'Show an Google AdSense (' .
                    $provider->name . ') block in your sidebar as a widget.');
      parent::WP_Widget($name, 'Google AdSense: ' . $provider->name, $widget_ops);
    }
    public static function setProvider(&$p) {
      self::$provider =& $p ;
    }
    function decorate($adText) {// apply styles
      if (empty($this->style))
        $inline = '' ;
      else
        $inline = 'style="' . $this->style . '"' ;
      if (!empty($adText))
          echo '<div class="google-adsense google-adsense-widget" ' .
            $inline . '>' . $adText . "</div>\n" ;
    }
    function widget($args, $instance) {
      extract( $args );
      $title = '' ;
      if (!empty($instance['title']))
        $title = apply_filters('widget_title', $instance['title']);
      echo $before_widget;
      if ( $title )
        echo $before_title . $title . $after_title;
      $adText = stripslashes(self::$provider->get('widget-text')) ;
      if (empty($adText)) echo "Empty Widget Text from <code>" . $this->name . "</code>" ;
      else {
        $adText = ezExtras::handleDefaultText($adText,'160x600') ;
        echo $this->decorate($adText) ;
        echo $after_widget;
      }
    }
    function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['title'] = '' ;
      if (!empty($new_instance['title']))
        $instance['title'] = strip_tags($new_instance['title']);
      return $instance;
    }
    function form($instance) {
      $title = '' ;
      if (!empty($instance['title'])) $title = esc_attr($instance['title']);
      echo '<p><label for="', $this->get_field_id('title'),
        '">Title:  <input class="widefat" id="', $this->get_field_id('title'),
        '" name="', $this->get_field_name('title'), '" type="text" value="',
        $title, '" /></label></p>' ;
      echo '<p>Configure it at <br />' ;
      echo '<a href="options-general.php?page=google-adsense-lite.php"> ';
      echo 'Settings &rarr; Google AdSense</a>' ;
      echo '</p>' ;
    }
  } // class providerWidget
}
if (!class_exists('Overview')) {
  class Overview extends ezOverview {
    function __construct() {
      $this->name = "Overview" ;
      $this->isActive = false ;
      $this->isAdmin = true ;
    }

    function renderContent()
    {
      $name = $this->name ;
      $instructionText = '<h4>Instructions</h4>' .
        '<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >' .
        ezTab::makeLIwithTooltip('Sign up',
          'Sign up for the ad providers shown on the right (which will give me ' .
          'some referral income).') .
        ezTab::makeLIwithTooltip('Generate Code',
          'Generate your ad code from the ad-provider web site.') .
        ezTab::makeLIwithTooltip('Enter Code',
          'Enter your ad code into the text-boxes under the ad providers tabs.') .
        ezTab::makeLIwithTooltip('Configure',
          'If needed, configure other options for each ad provider in the corresponding tab.') .
        "</ul><br />\n" ;
      $fetureText = '<h4>Features</h4>' .
        '<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >' .
        ezTab::makeLIwithTooltip('Admin Control Panel',
          'The <b>Admin</b> tab gives you general options that apply to all providers, ' .
          'and common tools and actions (like Reset All Options, Clean Database etc.) ' .
          'You also have a button to migrate options between different plugin versions.') .
        ezTab::makeLIwithTooltip('Positions and Slots',
          'Three positions (Top, Middle and Bottom) and a configurable number of ' .
          'slots for ads. (See the Admin Tab for details and an illustration.') .
        ezTab::makeLIwithTooltip('Custom Field Control',
          'In Google AdSense, you have more options [through <strong>custom fields</strong>] ' .
          'to control ad blocks in individual posts/pages. Add custom fields with keys ' .
          'like <strong>google-adsense-top, google-adsense-middle, ' .
          'google-adsense-bottom</strong> and with values like <strong>left, right, ' .
          'center</strong> or <strong>no</strong> to have control how the ad blocks show ' .
          'up in each post or page. The value <strong>no</strong> suppresses all the ad ' .
          'blocks in the post or page for that provider.') .
        ezTab::makeLIwithTooltip('CSS Control',
          'All <code>&lt;div&gt;</code>s that Google AdSense creates have the class attribute ' .
          '<code>google-adsense</code>. Furthermore, they have class attributes like ' .
          '<code>google-adsense-top</code> ' .
          'etc., (ie, <code>google-adsense-position</code>). You can set the style ' .
          'for these classes in your theme <code>style.css</code> to control their ' .
          'appearance.') .
        "</ul><br />\n" ;
      $planText = '<h4>Future Plans</h4>' .
        '<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >' .
        ezTab::makeLIwithTooltip('Widgets',
          'I will release options to include sidebar widgets with optional ad ' .
          'customization. That is, you will be able to use the same ad code for ' .
          'both main text and the widgets, or have different texts, ' .
          'to be customized on the widgets page.') .
        ezTab::makeLIwithTooltip('Ad Rotation',
          'I will provide means to rotate ads among various providers ' .
          'with user-defined frequency.') .
        ezTab::makeLIwithTooltip('More Providers',
          'This plugin is designed with extensibility in mind. I will keep adding more ' .
          'ad providers, or even let the end-users add them.') .
        ezTab::makeLIwithTooltip('Provider Specificity',
          'This initial release treats all ad providers essentially the same way. ' .
          'In the next release, I will start introducing more specificity, ' .
          'like specialized fields for HopID, PubID, colors, etc.') .
        ezTab::makeLIwithTooltip('Expertise Level',
          'I plan to introduce expertise levels (Easy, Advanced and Expert tabs) ' .
          'within the tab for each ad provider.') .
        ezTab::makeLIwithTooltip('Max Number of Ad blocks',
          'Since some providers require you to limit the number of ad blocks to some ' .
          'policy-driven ceiling, I will expose that option to you.<br />' .
          'Also to be customized is the number of ads per slot. In this initial release, ' .
          'there are three slots (top, middle and bottom), each of which can take two ' .
          'ad blocks. In a future release, you will have much more customization options.') .
        ezTab::makeLIwithTooltip('Ad Block Customization',
          'Right now, all the ad blocks are designed to display the same ad code, ' .
          'for which the providers will serve different text. In a future release, ' .
          'I will give you a means of introducing different texts for different locations, ' .
          'possibly in a tabbed interface.') .
        ezTab::makeLIwithTooltip('Internationalization',
          'Future versions will provide MO/PO files for internationalization.') .
        "</ul><br />\n" ;
      echo '<table width="95%">', "\n" ;
      echo '<tr align="center" valign="middle">', "\n" ;
      echo '<td width="46%">', "\n" ;
      echo '<table width="100%">', "\n" ;
      echo '<tr align="center" valign="middle">', "\n" ;
      echo '<td align="left">', "\n" ;
      echo $instructionText ;
      echo $fetureText ;
      echo $planText ;
      echo '<table><tr>' ;
      include ('myPlugins.php');
      $plgName = 'google-adsense' ;
      include ('head-text.php');
      echo '</tr></table>' ;
      echo "</td></tr></table>\n" ;
      echo "</td>\n" ;
      echo '<td width="54%">', "\n" ;
      echo '<table width="100%">' ;
      echo '<tr><th colspan="2">The following providers are supported</th></tr>', "\n" ;
      if ($this->checkDependencyInjection(__FUNCTION__)) {
        $ezPlugin =& $this->plugin ;
         foreach ($ezPlugin->tabs as $p) {
          if (!$p->isAdmin)
          {
            echo '<tr align="center" valign="middle">', "\n" ;
            echo '<td width="33%">' ;
            echo htmlspecialchars_decode($p->referral) ;
            echo "<br /><br /></td>\n" ;
            echo "<td align='left'>", $p->options['info']->desc, "</td>\n" ;
            echo "</tr>\n" ;
          }
        }
      }
      echo "</table></td>\n" ;
      echo "</tr></table>\n" ;
    }
  } // End: Class Overview
}
if (!class_exists('Admin')) {
  class Admin extends ezAdmin {
    function __construct() {
      parent::ezAdmin("Admin", "") ;
      $this->isActive = false ;
      $this->isAdmin = true ;
    }
    function renderContent() {
      $infoText = '<h4>Ad Positions, Slots and Blocks</h4>' .
        'You can define ad blocks in three positions in your post - Top, Middle ' .
        'and Bottom. Each position can have multiple "slots". See the picture ' .
        'for details. By default, you have one slot per position, but you can ' .
        'change it below [Pro feature]. In addition, you have widgets ' .
        'that you can place anywhere on your sidebar as many times ' .
        'as you want, by <a href="widgets.php"> Appearance &rarr; Widgets</a>.' ;
      $compText = '<h4>Competition</h4>' .
        'Other providers may not all be compatible with Google AdSense or with ' .
        'each other, or, in particular, with AdSense. Be careful how you use ' .
        'them. But competition is probably a good thing. You may find your ' .
        'earnings go up because of it, which is the objective behind my many  ' .
        'advertising plugins.' ;
      $adminText = '<h4>Admin Control Panel</h4>' .
        'This Admin tab gives you a control panel with tools and options that ' .
        'apply to the ad blocks from all the providers, en masse. You can '.
        '<ul style="padding-left:10px;list-style-type:circle; list-style-position:inside;" >' .
        ezTab::makeLIwithTooltip('Set Active',
          'By checking the box against their name below, you can set an ad provider ' .
          'as <b>Active</b> so that their ads appear on your pages. When you ' .
          'deactivate a provider, the corresponding tab header  will sport red fonts.') .
        ezTab::makeLIwithTooltip('Reset All Options',
          'You can reset all options to their default values if you feel that you ' .
          'have irrevocably messed them up.') .
        ezTab::makeLIwithTooltip('Migrate Options ',
          'When you upgrade the plugin to a newer version, some of the options ' .
          'may become incompatible. You can migrate your old options (to the ' .
          'extent possible) to the new version using this button.') .
        ezTab::makeLIwithTooltip('Clean Database',
          'This button gives you the option of cleaning all the Google AdSense ' .
          'options from your databse as a prelude to deactivating or deleting ' .
          'your plugin. In a future release, you will have a button to deactivate ' .
          'the plugin directly.') .
        "</ul><br />\n" ;
      if ($this->checkDependencyInjection(__FUNCTION__)) $url = $this->plugin->URL ;
      else $url = '/wp-content/plugins/google-adsense' ;
      $picText = "<span id='ad-slot' style='text-decoration:underline' " .
        "onmouseover=\"Tip('" .
        htmlspecialchars("In the Pro version, you can see an illustration of the ad slots.<br /><a href=\"http://buy.thulasidas.com/google-adsense\" title=\"Buy the Pro version of the Google AdSense plugin for \$5.95\"><b>Get Pro Version!</b></a>") .
        "', WIDTH, 200,  FIX, [this, -40, -140], " .
        "TITLE, 'Click to close', STICKY, 1, CLOSEBTN, true, CLICKCLOSE, true)\" onmouseout=" .
        "\"UnTip()\">Hover on the picture to see details<br /><br />".
        "<img src='" . $url . "/ad-slots-small.gif' " .
        "border='0' alt='[ad-slots-small]' /></span>" ;
      echo '<table width="95%" style="padding:10px;border-spacing:10px;">' . "\n" ;
      echo '<tr><th colspan="2"><h3>General Information</h3></th></tr>' . "\n" ;
      echo '<tr align="center" valign="middle">', "\n" ;
      echo '<td align="left" width="50%">', "\n" ;
      echo $infoText ;
      echo "</td>\n" ;
      echo "<td>\n" ;
      echo $picText ;
      echo "</td></tr>\n" ;
      echo '<tr><td>' ;
      echo $adminText ;
      echo "</td>\n" ;
      echo "<td>\n" ;
      echo $compText ;
      echo "</td></tr>\n" ;
      echo '<tr><th colspan="2"><h3>Global Options</h3></th></tr>', "\n" ;
      echo "</table>\n" ;
    }
    function renderForm() {
      echo ('<div style="background-color:#cff;padding:5px;border: solid 1px">') ;
      $plgName = 'google-adsense' ;
      @include('myPlugins.php') ;
      @include (dirname (__FILE__).'/why-pro.php');
      echo ('</div>') ;
    }
    function defineOptions() {
      unset($this->options) ;
    }
    function defineSubmitButtons() { // Add submit buttons
      unset($this->submitButtons) ;

      $button = &$this->addSubmitButton('submit', 'update') ;
      $properties = array('value' => 'Save Changes',
          'title' => "Save the changes as specified above.");
      $button->set($properties) ;

      $button = &$this->addSubmitButton('submit', 'reset') ;
      $properties = array('value' => 'Reset All Options',
          'title' => 'DANGER: Reset all the options to default.');
      $button->set($properties) ;

      $button = &$this->addSubmitButton('submit', 'migrate') ;
      $properties = array('value' => 'Migrate Options',
          'title' => 'Update the options to be compatible with ' .
                    'the current version of the plugin.');
      $button->set($properties) ;

      $button = &$this->addSubmitButton('submit', 'clean_db0') ;
      $properties = array('value' => 'Clean Database',
          'title' => 'DANGER: Delete all options from the database.  [Not active yet.]');
      $button->set($properties) ;
    }
  } // End: Class Admin
}
if (!class_exists('About')) {
  class About extends ezAbout {}
}
?>
