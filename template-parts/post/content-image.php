<?php
$post_format = get_post_format() ? : 'standard';
$author_id = get_the_author_meta('ID');
$author_name = get_the_author_meta("display_name", $author_id);
$author_url = get_author_posts_url($author_id);
$author_bio = get_the_author_meta("description");
$author_avatar = get_avatar_url($author_id, ['size' => '80']);
$a_reading_time = alt_reading_time(get_the_content());
$post_categories = get_the_category();

$category_color = alt_tax_color($post_categories[0]);
$category_link = get_category_link($post_categories[0]);

alt_post_thumbnail($post_format);
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(Array("post", "container")); ?> itemscope itemtype="http://schema.org/BlogPosting">
  <header class="alt-post-margins alt-top-title white-back">
    <a class="breadcrumb-back-button" href="<?php echo esc_attr($category_link); ?>" aria-expanded="true" role="button"><i class="fas fa-reply"></i>&nbsp;<?php _e("back", "altminimo"); ?></a>
    <h1 class="post-title basic-mono" itemprop="name headline"><?php the_title(); ?></h1>
    <h2 class="post-subtitle"><?php echo esc_html(strip_tags(get_the_excerpt(), "<span>")); ?></h2>
    <div class="container post-metabox mt-3 pl-2 pl-md-0">

        <div class="row justify-content-start">
          <div class="post-metabox-avatar-box">
            <a href="<?php echo esc_attr($author_url); ?>" rel="noopener">
              <img alt="user-avatar" class="post-user-avatar img-fluid img-thumbnail" src="<?php echo esc_attr($author_avatar); ?>" width="51" height="51">
            </a>
          </div>
          <div class="post-metabox-right">

              <a href="<?php echo esc_attr($author_url); ?>" rel="noopener"><?php echo esc_html($author_name); ?></a>

              <div class="post-metabox-bottom">
                <a rel="noopener" href="<?php the_permalink(); ?>">
                  <time datetime="<?php echo esc_attr(get_the_date('F j, Y')); ?>" itemprop="datePublished"><?php echo esc_html(get_the_date('j M')); ?></time>

                </a> &middot; <span data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr($a_reading_time["word_count"]." ".__("words", "altminimo")); ?>"><?php echo esc_html($a_reading_time["reading_time"]); ?> min.</span>

                <span style="padding-left: 4px;">
                  <svg class="star-15px_svg__svgIcon-use" width="15" height="15" viewBox="0 0 15 15" style="margin-top: -2px;"><path d="M7.44 2.32c.03-.1.09-.1.12 0l1.2 3.53a.29.29 0 0 0 .26.2h3.88c.11 0 .13.04.04.1L9.8 8.33a.27.27 0 0 0-.1.29l1.2 3.53c.03.1-.01.13-.1.07l-3.14-2.18a.3.3 0 0 0-.32 0L4.2 12.22c-.1.06-.14.03-.1-.07l1.2-3.53a.27.27 0 0 0-.1-.3L2.06 6.16c-.1-.06-.07-.12.03-.12h3.89a.29.29 0 0 0 .26-.19l1.2-3.52z"></path></svg>
                </span>
              </div>
          </div>
        </div>
    </div>
  </header>

  <div class="post-content white-back" itemprop="articleBody">
    <?php
    the_content();

    $post_tags = get_the_tags();
    if ($post_tags){
      echo "<br>";
      echo "<div class='tag-box'>";
      foreach ($post_tags as $tag_key => $tag){
        $tag_link = get_tag_link($tag);
        echo '<a class="btn btn-light" href="'.esc_attr($tag_link).'" role="button">'.esc_html($tag->name).'</a> ';
      }
      echo '</div>';
    }
    ?>
    <?php alt_pagination(); ?>
    <br><hr><br>

     <div class="post-bottom-metabox container">

         <div class="row justify-content-start">

           <div class="col-flex post-bottom-metabox-left">
             <a href="<?php echo esc_attr($author_url); ?>" rel="noopener">
               <img alt="user-avatar" class="post-bottom-user-avatar img-fluid img-thumbnail" src="<?php echo esc_attr($author_avatar); ?>" width="80" height="80">
             </a>
           </div>

           <div class="col post-bottom-metabox-right">
             <div class="post-bottom-metabox-right-by text-uppercase">
              <?php
              echo __("Wrote for", "altminimo")." <a class='btn btn-sm btn-".$category_color."' href='".esc_attr($category_link)."' role='button'>".esc_html($post_categories[0]->name)."</a>";
              ?>

             </div>

               <a class="post-bottom-metabox-author-name" href="<?php echo esc_attr($author_url); ?>" rel="noopener"><?php echo esc_html($author_name); ?></a>

               <div class="post-bottom-metabox-bottom">

                 <div class="post-bottom-metabox-bottom-bio"><?php echo esc_html($author_bio); ?></div>

               </div>
           </div>

         </div>
     </div>
  </div>


  <div class="post-divider"><hr></div>

  <?php
  if ( comments_open() || get_comments_number() ) {
   comments_template();
  }
  ?>
</article>
