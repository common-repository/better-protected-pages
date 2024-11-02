<?php
/*
Plugin Name: Better Protected Pages
Plugin URI: http://www.madeglobal.com/wordpress/better-protected-pages
Description: Greatly improves the look and functionality of protected pages
Version: 1.0
Author: Tim Ridgway
Author URI: http://www.madeglobal.com/wordpress

  Copyright 2009  Tim Ridgway  (email : info@madeglobal.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//global defines for this plugin
define('BETTER_PROTECTED_TOP','better_protected_top');
define('BETTER_PROTECTED_BOTTOM','better_protected_bottom');
define('BETTER_PROTECTED_PASSWORD_NAME','better_protected_password_name');
define('BETTER_PROTECTED_DISABLE_CSS','better_protected_disable_css');
define('BETTER_PROTECTED_DISABLE_RELOCK','better_protected_disable_relock');
define('BETTER_PROTECTED_SHOW_EXCERPT','better_protected_show_excerpt');
if ( ! defined( 'WP_PLUGIN_URL' ) )   // backwards compatibility path to plugin
  define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );

// Hook for adding admin menus
add_action('admin_menu', 'better_protected_pages_add_page');

// action function for above hook
function better_protected_pages_add_page() {
    // Add a new submenu under Settings menu (options):
    add_options_page('Better Protected pages','Better Protected Pages',10,'betterprotectedpages','better_protected_pages_option_page');
}

// displays the page content for the Test Options submenu
function better_protected_pages_option_page() {

    // variables for the field and option names 
    $show_excerpt_name = BETTER_PROTECTED_SHOW_EXCERPT;
    $show_excerpt_field = 'better_protected_show_excerpt_field';
    $top_name = BETTER_PROTECTED_TOP;
    $top_field = 'better_protected_top_field';
    $bottom_name = BETTER_PROTECTED_BOTTOM;
    $bottom_field = 'better_protected_bottom_field';   
    $password_name = BETTER_PROTECTED_PASSWORD_NAME;
    $password_field = 'better_protected_password_field';
    $disable_css_name = BETTER_PROTECTED_DISABLE_CSS;
    $disable_css_field = 'better_protected_disable_css_field';
    $disable_relock_name = BETTER_PROTECTED_DISABLE_RELOCK;
    $disable_relock_field = 'better_protected_disable_relock_field';
    
    $hidden_field_name = 'better_protected_submit_hidden';

    // Read in existing option value from database
    $show_excerpt = get_option( $show_excerpt_name );
    $top_val = get_option( $top_name );
    $bottom_val = get_option( $bottom_name );
    $password_val = get_option( $password_name );
    $disable_css = get_option( $disable_css_name );
    $disable_relock = get_option( $disable_css_relock );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $show_excerpt = $_POST[ $show_excerpt_field ];
        $top_val = $_POST[ $top_field ];
        $bottom_val = $_POST[ $bottom_field ];
        $password_val = $_POST[ $password_field ];
        $disable_css = $_POST[ $disable_css_field ];
        $disable_relock = $_POST[ $disable_relock_field ];

        // Save the posted value in the database
        update_option( $show_excerpt_name, $show_excerpt );
        update_option( $top_name, $top_val );
        update_option( $bottom_name, $bottom_val );
        update_option( $password_name, $password_val );
        update_option( $disable_css_name, $disable_css );
        update_option( $disable_relock_name, $disable_relock );
       
        // Put an options updated message on the screen
?>
<div class="updated"><p><strong><?php _e('Options saved.', 'better_protected_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Better Protected Pages', 'better_protected_trans_domain' ) . "</h2>";

    // options form
    
    ?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><input name="<?php echo $show_excerpt_field; ?>" id="<?php echo $show_excerpt_field; ?>" type="checkbox" value="1" <?php checked('1', get_option($show_excerpt_name)); ?> />
<?php _e(" Show excerpt in private posts (excerpt/up to READ MORE) ", 'better_protected_trans_domain' ); ?></p>

<p><?php _e("Text above the password box: (HTML is acceptable)", 'better_protected_trans_domain' ); ?> <br />
<textarea name="<?php echo $top_field; ?>" cols="80" rows="5"><?php echo htmlentities($top_val); ?></textarea>
</p>
<p><?php _e("Bottom Text: (HTML is acceptable)", 'better_protected_trans_domain' ); ?> <br />
<textarea name="<?php echo $bottom_field; ?>" cols="80" rows="5"><?php echo htmlentities($bottom_val); ?></textarea>
</p>
<p><?php _e("Text above password box: (HTML is acceptable) - default is Password:", 'better_protected_trans_domain' ); ?><br />
<textarea name="<?php echo $password_field; ?>" cols="80" rows="3"><?php echo htmlentities($password_val); ?></textarea>
</p>

<p><input name="<?php echo $disable_css_field; ?>" id="<?php echo $disable_css_field; ?>" type="checkbox" value="1" <?php checked('1', get_option($disable_css_name)); ?> />
<?php _e(" Disable the CSS from this plugin", 'better_protected_trans_domain' ); ?></p>
<p><input name="<?php echo $disable_relock_field; ?>" id="<?php echo $disable_relock_field; ?>" type="checkbox" value="1" <?php checked('1', get_option($disable_relock_name)); ?> />
<?php _e(" Disable the RELOCK PAGE BUTTON created by this plugin", 'better_protected_trans_domain' ); ?></p>

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'better_protected_trans_domain' ) ?>" />
</p>
</form>

<p>If this plugin has helped you, please consider helping us to continue providing support...</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7109203">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>


</div>

<?php
// please forgive the donate button - you'll help to feed our cats if you donate - thank you, thank you 
}

// hook for the protected pages
function change_private_wording($content) {
  
  $output = '';
  
  //STEP 1: Clean up the incoming content
  // remove the default wording for the password page
  $content = str_replace(
  __("This post is password protected. To view it please enter your password below:"),
  '',
  $content);
  
  //replace the word Password with user's selected phrase
  $new_password_name = get_option(BETTER_PROTECTED_PASSWORD_NAME);
  if($new_password_name) {
    $content = str_replace(
    __("Password:"),
    '<div class="passwordphrase">'.$new_password_name.'</div>',
    $content);
  }

  // add a class for the submit button, again for CSS
  $content = str_replace(
  'type="submit"',
  'type="submit" class="passwordsubmit"',
  $content);  

  // and add a class for the password box
  $content = str_replace(
  'name="post_password"',
  'name="post_password" class="passwordentry"',
  $content);  
  
  //STEP 2: If selected, show the excerpt at the top of the page
	$post = get_post($post);

  $show_excerpt = get_option(BETTER_PROTECTED_SHOW_EXCERPT);
  if($show_excerpt) {
    if($post->post_excerpt){
       $output = $post->post_excerpt;
    } else {  // show up to the "read more"
       $intro = explode('<!--more-->', $post->post_content, 2);
       $output .= $intro[0];
    }
  }
     
  
  //STEP 3: Change the leftovers and prepare for CSS formating

  // add in the user's "top" text
  $output .= '<div class="passwordtopbox">'.get_option(BETTER_PROTECTED_TOP).'</div>';
  
  // wrap up the actual form so that CSS can style the password page
  $output .= '<div class="password">';
  //include the incoming content within our new class
  $output .= $content;
  // and finish the wrap
  $output .= '</div>';

  // and add the user's "bottom" text
  $output .= '<div class="passwordbottombox">'.get_option(BETTER_PROTECTED_BOTTOM).'</div>';
  
  return $output;
}

add_filter('the_password_form','change_private_wording');

// Add our CSS to the header, if not disabled in the options

function better_protected_pages_head() {
  $disable_css = get_option(BETTER_PROTECTED_DISABLE_CSS);
  if ($disable_css == '') {
    $css_path = WP_PLUGIN_URL.'/better-protected-pages/';
?>    
    <link rel="stylesheet" type="text/css" href="<?php echo $css_path ?>better-protected.css" />
<?php       
  }
}

add_action('wp_head', 'better_protected_pages_head');

// Add a "re-lock" button so that you can ... relock pages!
// this relies on clearing the cookie which is cached and normally means that once
// a page is unlocked, it stays unlocked ... scary for some WP users.

function better_has_a_password() {
	$post = get_post($post);

	if ( empty($post->post_password) ){
		return false;
  } else
    return true;
}

function add_relock_button ($content){
  $output = '';
  $disable_relock = get_option(BETTER_PROTECTED_DISABLE_RELOCK);
  if ($disable_relock == '') {
    if (better_has_a_password()&&!(strpos($content,'wp-pass.php')) ) { // only show the button on unlocked password protected pages
      
      $request_page = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);    
      $mynonce= wp_create_nonce('better-protected-pages');
    
      $output .= '<div class="relockbutton">';
      $output .= '<form name="relockform" method="post" action="'.WP_PLUGIN_URL.'/better-protected-pages/clear.php" >';
      $output .= '<input type="hidden" name="mynonce" value="'.$mynonce.'" >';
      $output .= '<input type="hidden" name="removecookie" value="Y" >';
      $output .= '<input type="hidden" name="redirect" value="'.$request_page.'" >';    
      $output .= '<p class="submit">';
      $output .= '<input type="submit" name="Submit" value="Lock This Page" />';
      $outupt .= '</p>';
      $output .= '</form>';
      $output .= '</div>';
    }
  }  
  return $output.$content;
};

add_filter('the_content','add_relock_button');


// Thanks - this plugin was brought to you by http://www.madeglobal.com
// PLEASE support us!
?>
