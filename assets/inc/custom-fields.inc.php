<?php
/**
 * Register meta boxes.
 */
function alt_register_meta_boxes() {
  $screens = get_post_types();
  add_meta_box( 'alt-custom-codes', __( 'CUSTOM CODES', 'altminimo' ), 'alt_display_callback' );
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function alt_display_callback( $post ) {

  wp_nonce_field( 'alt-custom-codes-nonce', 'alt-custom-codes-nonce' );

  $alt_custom_js = get_post_meta( $post->ID, '_alt_custom_js', true );
  $alt_custom_css = get_post_meta( $post->ID, '_alt_custom_css', true );

  echo '<div class="alt-custom-fields-box">
      <style scoped>
      .alt-custom-fields-box{
          display: grid;
          grid-template-columns: max-content 1fr;
          grid-row-gap: 10px;
          grid-column-gap: 20px;
      }
      .alt-custom-fields-box textarea{ height:150px;  }
      .alt_field{
          display: contents;
      }
      </style>
      <p class="meta-options alt_field">
          <label for="alt_custom_js">JS</label>
          <textarea class="components-textarea-control__input" id="alt_custom_js" name="alt_custom_js">'.esc_attr( $alt_custom_js ).'</textarea>
      </p>
      <p class="meta-options alt_field">
          <label for="alt_custom_css">CSS</label>
          <textarea class="components-textarea-control__input" id="alt_custom_css" name="alt_custom_css">'.esc_attr( $alt_custom_css ).'</textarea>
      </p>
  </div>
  ';
}


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_global_notice_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['alt-custom-codes-nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['alt-custom-codes-nonce'], 'alt-custom-codes-nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['alt_custom_js'] ) ) {
        return;
    }

    // Sanitize user input.
    $alt_custom_js = $_POST['alt_custom_js'];
    $alt_custom_css =  $_POST['alt_custom_css'];

    // Update the meta field in the database.
    update_post_meta( $post_id, '_alt_custom_js', $alt_custom_js );
    update_post_meta( $post_id, '_alt_custom_css', $alt_custom_css );
}
function alt_display_custom_code($code = Array("js", "css")){
  global $post;
  $ret  = "";
  if (in_array("js", $code)) {
    $alt_custom_js = get_post_meta( $post->ID, '_alt_custom_js', true );
    if (!empty($alt_custom_js)) $ret .= "<script>".$alt_custom_js."</script>";
  }
  if (in_array("css", $code)) {
    $alt_custom_css = get_post_meta( $post->ID, '_alt_custom_css', true );
    if (!empty($alt_custom_css)) $ret .= "<style>".$alt_custom_css."</style>";
  }
  return $ret;
}

function alt_print_custom_codes( $content ) {
    // global $post;
    return $content.alt_display_custom_code();

}
if ( is_admin() ) {
  add_action( 'add_meta_boxes', 'alt_register_meta_boxes' );
  add_action( 'save_post', 'save_global_notice_meta_box_data' );
}
add_filter( 'the_content', 'alt_print_custom_codes' );
?>
