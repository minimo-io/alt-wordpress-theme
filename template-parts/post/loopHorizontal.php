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
<li id="post-<?php the_ID(); ?>" class="col d-flex post-list-item <?php echo (is_home() ? "" : "px-0 px-lg-1"); ?>">


  <div class="card mb-2 mt-2">
    <div class="overlay overlay-<?php echo $badge_color; ?>"></div>
    <a href="<?php the_permalink(); ?>">
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

  <!-- <div class="card">
    <a href="<?php the_permalink(); ?>">
      <div class="overlay overlay-<?php echo $badge_color; ?>"></div>
      <?php if ($img_thumb){ ?><div class="card-image img-fluid" style="background-image:url(<?php echo esc_attr($img_thumb); ?>);"></div><?php } ?>


      <div class="card-body">

          <h5 class="card-title"><?php the_title(); ?></h5>
          <div class="card-text card-excerpt"><?php the_excerpt(); ?></div>
          <div class="card-text card-meta">
            <small class="text-muted">
              <?php echo __("By", "altminimo")." ".esc_html($author_name); ?> &nbsp;
              <?php echo esc_html(get_the_date('j M')); ?>
              <?php if (!is_category()) echo $html_cats; ?>
            </small>
          </div>

      </div>

    </a>

  </div> -->
</li>
