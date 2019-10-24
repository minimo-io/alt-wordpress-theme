<div class="card-posts-deck card-group">
  <ul class="card-list row list-unstyled">
    <?php
      $args = array(
          'post_type' => 'post',
          'orderby'   => 'rand',
          'posts_per_page' => 2,
          );

      $the_query = new WP_Query( $args );
       echo '<div class="card-posts-deck card-group">
               <ul class="card-list row list-unstyled">';
       while ( $the_query->have_posts() ) :
         $the_query->the_post();
         //get_template_part( 'template-parts/post/content', get_post_format() );
         get_template_part( 'template-parts/post/loop', "loop" );
       endwhile;
       wp_reset_query();
     echo '</ul>
       </div>';

    ?>
  </ul>
</div>
