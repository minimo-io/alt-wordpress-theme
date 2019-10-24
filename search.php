<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
$o_cat = $wp_query->get_queried_object();
$t_category_description = category_description();
$is_readmore = alt_reveal_more_button($t_category_description);
?>
<main id="main" class="site-main" role="main">
	<section id="sec-ethos" class="container main-container category-container">

    <header class="alt-post-header alt-top-title category-header white-back">
      <a class="breadcrumb-back-button" href="<?php echo home_url(); ?>" aria-expanded="true" role="button"><i class="fas fa-reply"></i>&nbsp;<?php _e("back", "altminimo"); ?></a>
      <h1 class="post-title basic-mono category-title" itemprop="name headline"><?php _e("Search", "altminimo"); ?>:&laquo;<?php echo esc_html( get_search_query() ); ?>&raquo;</h1>
    </header>

        <div class="nav-scroller bg-white">
					<div class="container second-container" style="padding-top: 1.6%;">
						<?php
            if ( have_posts() ):
    						echo '<div class="card-posts-deck card-group">
    										<ul class="card-list row list-unstyled">';
    						while ( have_posts() ) :
    							the_post();
                  get_template_part( 'template-parts/post/loop', "loop" );

    					  endwhile;
    				       echo '</ul>
    					           </div>';
             else :
							 ?>
							 <h2 class="post-subtitle" style="font-size:25px;">
	 					    <?php _e( 'Sorry, but there is not match for your search criteria. Please try again with different words.<br><br>Or check out these nice articles.', 'altminimo' ); ?>
	 					  </h2>
							 <?php
         			get_template_part( 'template-parts/post/none', 'none' );
         		endif;
					  ?>
					</div>
        </div>
				<div class="alt-pagination text-center">
					<?php
					// echo paginate_links();
					// don't display the button if there are not enough posts
					if (  $wp_query->max_num_pages > 1 ){
						echo '<button class="btn btn-secondary btn-loadmore"><i class="fas fa-plus"></i></button>';
					}
					?>
				</div>
	</section>
</main><!-- .site-main -->


<?php get_footer(); ?>
