<?php get_header(); ?>
<?php get_sidebar(); ?>

<main id="main" class="site-main" role="main">
	<section id="sec-ethos" class="container main-container">

        <div class="nav-scroller bg-white">
					<div class="container second-container">

						<?php
						$sticky = get_option( 'sticky_posts' );
						if (is_home() && !is_paged()){
						// args
						$args = array(
							'posts_per_page' => 1,
							'post_type'		=> 'post',
							'post__in' => $sticky,
							'ignore_sticky_posts' => 1
						);

						// query
						$the_query = new WP_Query( $args );
						if ( isset( $sticky[0] ) ):
						?>
						<?php if( $the_query->have_posts() ): ?>
							<div id="carousel-homepage" class="carousel slide carousel-featured" data-ride="carousel">
									<div class="carousel-inner">
										<?php
										$c_carrousel = 0;
										?>
									<?php while( $the_query->have_posts() ) : $the_query->the_post(); ?>
											<?php
											$a_post_cats = get_the_category();
											$badge_color = "primary";
											$html_cats = "";
											$author_id = get_the_author_meta('ID');
											$author_name = get_the_author_meta("display_name", $author_id);
											$image_url = get_the_post_thumbnail_url();

											if (!is_category()){
												foreach ($a_post_cats as $cat_key => $cat){

													$badge_color = alt_tax_color($cat);
													if ($html_cats != "") $html_cats .= " ";
													$html_cats .= '<a href="'.get_category_link( $cat->term_id ).'" class="badge badge-'.$badge_color.' Xbadge-featured">'.$cat->name.'</a>';
												}
											}
											?>
								      <div class="carousel-item <?php echo ($c_carrousel == 0 ? "active" : ""); ?>">
												<a href="<?php the_permalink(); ?>">
													<div class="overlay overlay-<?php echo $badge_color; ?>"></div>
									        <?php if ($image_url){ ?><img class="d-block w-100 img-fluid rounded" alt="carousel-image-1" src="<?php echo $image_url; ?>"><?php } ?>

													<div class="card">
				 										 <div class="card-body">
															 		<h5 class="card-title"><?php the_title(); ?></h5>
				 												 <div class="card-text card-excerpt"><?php the_excerpt(); ?></div>
				 												 <div class="card-text card-meta">
				 													 <small class="text-muted">
				 														 <?php echo __("By ", "altminimo").$author_name; ?> &nbsp;
				 														 <?php echo get_the_date('j M') ?>
				 														 <?php echo $html_cats; ?>
				 													 </small>
				 												 </div>

				 										 </div>
				 									</div>
												</a>

								      </div>





											<?php
											$c_carrousel++;
											?>

									<?php endwhile; ?>
									<?php
									if ($c_carrousel > 1){
										?>
										<ol class="carousel-indicators">
											<?php
											for ($i = 0; $i < $c_carrousel; $i++){
													echo '<li data-target="#carousel-homepage" data-slide-to="'.$i.'" '.($i==0 ? "class='active'" : "").'></li>';
											}
											?>
									  </ol>
										<?php
									}
									?>

									</div>
							 </div>

							<?php endif; ?>
						<?php endif; ?>
						<?php

						wp_reset_query();
						}


						if ( have_posts() ):
							echo '<div class="card-posts-deck card-group">
											<ul class="card-list row list-unstyled">';
							while ( have_posts() ) :
								the_post();
								//get_template_part( 'template-parts/post/content', get_post_format() );
								get_template_part( 'template-parts/post/loop', "loop" );
							endwhile;
							echo '</ul></div>';
						else :
							?>
							<h2 class="post-subtitle" style="font-size:25px;">
							 <?php _e( 'This is sad... we have nothing to show yet :\\', 'altminimo' ); ?>
						 </h2>
						 <?php
						endif;
					?>
					</div>
        </div>
				<div class="alt-pagination text-center">
					<?php alt_pagination(); ?>
				</div>
	</section>
</main><!-- .site-main -->


<?php get_footer(); ?>
