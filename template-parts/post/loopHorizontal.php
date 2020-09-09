<?php
$a_post_cats = get_the_category();
$author_id = get_the_author_meta('ID');
$author_name = get_the_author_meta("display_name", $author_id);
$img_thumb = get_the_post_thumbnail_url(get_the_ID(), 'medium');

$badge_color = "primary";
$html_cats = "";

foreach ($a_post_cats as $cat_key => $cat){

  $badge_color = alt_tax_color($cat);
  $html_cats .= '&nbsp;<a href="'.esc_attr(get_category_link( $cat->term_id )).'" class="badge badge-'.$badge_color.'">'.esc_html($cat->name).'</a>';
}

?>
<li id="post-<?php the_ID(); ?>" class="col-12 post-list-item <?php echo (is_home() ? "" : "px-0 px-lg-1"); ?>">


  <div class="card">
    <a href="<?php the_permalink(); ?>">
    <div class="overlay overlay-<?php echo $badge_color; ?>"></div>

      <div class="row no-gutters">
        <div class="col-md-4">
          <img src="<?php echo esc_attr($img_thumb); ?>" class="card-img h-100" alt="porque-si" data-recalc-dims="1">
        </div>
        <div class="col-md-8">
          <div class="card-body">
          <h5 class="card-title pt-0 pt-lg-4" style="color:black;"><?php the_title(); ?></h5>
          <p class="card-text" style="color:black;"><?php the_excerpt(); ?></p>
          </div>
        </div>
      </div>
    </a>
  </div>

</li>
