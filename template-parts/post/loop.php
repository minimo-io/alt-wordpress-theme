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
<li id="post-<?php the_ID(); ?>" class="col-md-4 d-flex post-list-item <?php echo (is_home() ? "" : "px-0 px-lg-1"); ?>">
  <div class="card">
    <a href="<?php the_permalink(); ?>">
      <div class="overlay overlay-<?php echo $badge_color; ?>"></div>
      <?php if ($img_thumb){ ?><div class="card-image img-fluid" style="background-image:url(<?php echo esc_attr($img_thumb); ?>);"></div><?php } ?>


      <div class="card-body">

          <h5 class="card-title"><?php the_title(); ?></h5>
          <div class="card-text card-excerpt"><?php the_excerpt(); ?></div>
          <div class="card-text card-meta">
            <small class="text-muted">
              <?php
              // echo __("By", "altminimo")." ".esc_html($author_name);
              ?>
              <!-- &nbsp; -->
              <?php echo esc_html(get_the_date('j M')); ?>
              <?php if (!is_category()) echo $html_cats; ?>
            </small>
          </div>

      </div>

    </a>

  </div>
</li>
