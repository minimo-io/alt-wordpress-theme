<?php

// add_action ( 'edit_category_form_fields', 'alt_category_extra_fields');
add_action ( 'category_edit_form_fields', 'alt_category_extra_fields');
add_action ( 'category_add_form_fields', 'alt_category_extra_fields');

add_action ( 'edit_tag_form_fields', 'alt_category_extra_fields');
add_action ( 'add_tag_form_fields', 'alt_category_extra_fields');

add_action('create_category', 'alt_save_category_extra_fields', 10, 2);
add_action ( 'edited_category', 'alt_save_category_extra_fields');

add_action('create_post_tag', 'alt_save_category_extra_fields', 10, 2);
add_action ( 'edit_post_tag', 'alt_save_category_extra_fields');


function alt_category_extra_fields( $tag ) {    //check for existing featured ID
    $t_id = $tag->term_id;
    $category_color = get_option( "category_color_".$t_id);

    $a_cats_colors = Array();
    $a_cats_colors["primary"] = __("Blue", "altminimo");
    $a_cats_colors["pink"] = __("Pink", "altminimo");
    $a_cats_colors["danger"] = __("Red", "altminimo");
    $a_cats_colors["warning"] = __("Yellow", "altminimo");
    $a_cats_colors["orange"] = __("Orange", "altminimo");
    $a_cats_colors["green"] = __("Green", "altminimo");
    $a_cats_colors["cian"] = __("Cyan", "altminimo");
    $a_cats_colors["purple"] = __("Purple", "altminimo");
    $a_cats_colors["dark"] = __("Black", "altminimo");
    $a_cats_colors["info"] = __("Cadet Blue", "altminimo");
    $a_cats_colors["success"] = __("Steel Blue", "altminimo");
    $a_cats_colors["light"] = __("Light", "altminimo");
    $a_cats_colors["secondary"] = __("Grey", "altminimo");
?>
<tr class="form-field">
  <th scope="row" valign="top"><label for="category_color"><?php _e('Category Color', "altminimo"); ?></label></th>
  <td>
    <select name="category_color" id="category_color">
      <?php
      foreach ($a_cats_colors as $color_key => $color_name){
        echo "<option ".($category_color == $color_key ? "selected" : "")." value='".esc_attr($color_key)."'>".esc_html($color_name)."</option>";
      }
      ?>
    </select>
    <p class="description"><?php _e('Category Color', "altminimo"); ?></p>
    <br>
  </td>
</tr>
<?php
}


function alt_save_category_extra_fields( $term_id ) {
    if ( isset( $_POST['category_color'] ) ) {
        $r_opt = update_option( "category_color_".$term_id, $_POST['category_color'] );

    }
}
?>
