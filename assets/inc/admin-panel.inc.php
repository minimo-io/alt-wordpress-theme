<?php

/** Step 2 (from text above). */
add_action( 'admin_menu', 'alt_theme_menu' );

/** Step 1. */
function alt_theme_menu() {

  add_theme_page(
          'ALT.',
          'ALT.',
          'manage_options',
          'alt-menu-page',
          'alt_settings_page'
      );
    // Activate settings
    add_action( 'admin_init', 'alt_menu_page_settings' );
}

/**
 *  Register all the settings field and sections
 */
function alt_menu_page_settings() {
  // Segundo paso...registrar las secciones y campos para que WP los reconozca
  register_setting( 'alt-menu-page-settings-group', 'alt_suscription_url' );
  register_setting( 'alt-menu-page-settings-group', 'alt_subscriptionButtonText' );
  register_setting( 'alt-menu-page-settings-group', 'alt_whatsapp_url' );
  register_setting( 'alt-menu-page-settings-group', 'alt_us_url' );

  add_settings_section( 'alt_settings_page_url', __("Links", "altminimo"), null, 'alt_settings_page_url_options' );

  add_settings_field( 'alt_suscription_url', __("Subscription", "altminimo"), 'echo_alt_suscription', 'alt_settings_page_url_options', 'alt_settings_page_url' );
  add_settings_field( 'alt_subscriptionButtonText', __("Subscription", "altminimo"), 'echo_alt_subscriptionButtonText', 'alt_settings_page_url_options', 'alt_settings_page_url' );
  add_settings_field( 'alt_suscription_whatsapp', "Whatsapp", 'echo_alt_whatsapp', 'alt_settings_page_url_options', 'alt_settings_page_url' );
  add_settings_field( 'alt_suscription_us', "Us", 'echo_alt_us', 'alt_settings_page_url_options', 'alt_settings_page_url' );
}

function echo_alt_suscription(){
  // Read in existing option value from database
  $alt_suscription_url = get_option( "alt_suscription_url" );
  ?>
  <input type="url" placeholder="http://www.google.com/suscribe" value="<?php echo esc_attr($alt_suscription_url); ?>" name="alt_suscription_url" value="" id="url" class="regular-text code">
  <p class="description" id="email-description">
    <?php _e("This element is visible in the top menu.<br>Leave blank to hide it.", "altminimo"); ?>
  </p>
  <?php
}
function echo_alt_whatsapp(){
  $alt_whatsapp_url = get_option( "alt_whatsapp_url" );
  ?>
  <input type="url" placeholder="https://wa.me/59896666901" name="alt_whatsapp_url" value="<?php echo esc_attr($alt_whatsapp_url); ?>" id="alt_whatsapp_url" class="regular-text code">
  <p class="description" id="email-description">
    <?php _e("This element is visible after opening the main menu.<br>Leave blank to hide it.", "altminimo"); ?>
  </p>
  <?php
}
function echo_alt_subscriptionButtonText(){
  $alt_subscribe_button_url = get_option( "alt_subscribe_button_url" );
  ?>
  <input type="text" placeholder="<?php _e("Subscribe", "aipim"); ?>" name="alt_subscriptionButtonText" value="<?php echo esc_attr($alt_subscribe_button_url); ?>" id="alt_subscriptionButtonText" class="regular-text code">
  <p class="description" id="alt_subscribe_button_url">
    <?php _e("Menu button.", "altminimo"); ?>
  </p>
  <?php
}
function echo_alt_us(){
  $alt_us_url = get_option( "alt_us_url" );
  ?>
  <input type="url" placeholder="" name="alt_us_url" value="<?php echo esc_attr($alt_us_url); ?>" id="alt_us_url" class="regular-text code">
  <p class="description" id="email-description">
   <?php _e("This element is visible after opening the main menu.<br>Leave blank to hide it.", "altminimo"); ?>
  </p>
  <?php
}

function alt_settings_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page', 'altminimo' ) );
	}

  // See if the user has posted us some information
  // If they did, this hidden field will be set to 'Y'
  if( isset($_POST["alt_suscription_url"])
  || isset($_POST["alt_whatsapp_url"])
  || isset($_POST["alt_subscriptionButtonText"])
  || isset($_POST["alt_us_url"])) {
      // Read their posted value


      // Save the posted value in the database
      update_option( "alt_suscription_url", $_POST["alt_suscription_url"] );
      update_option( "alt_subscriptionButtonText", $_POST["alt_subscriptionButtonText"] );
      update_option( "alt_whatsapp_url", $_POST["alt_whatsapp_url"] );
      update_option( "alt_us_url", $_POST["alt_us_url"] );

      // Put a "settings saved" message on the screen
      echo '<div class="updated"><p><strong>'.__('Changes saved.', 'altminimo' ).'</strong></p></div>';

    }
?>


  <div class="wrap">
    <?php settings_errors(); ?>
    <h1 class='wp-heading-inline'><?php _e('ALT. Configuration', 'altminimo' ); ?></h1>
    <form name="form1" method="post" action="">
      <?php settings_fields( 'alt_settings_page_url' ); ?>
      <?php do_settings_sections( 'alt_settings_page_url_options' ); ?>
      <?php submit_button(); ?>
    </form>
  </div>
  <?php
}

?>
