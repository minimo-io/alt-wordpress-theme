<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
// Start the loop.
while ( have_posts() ) :
  the_post();
  get_template_part( 'template-parts/post/content', get_post_format() );
endwhile;
get_footer();
?>
