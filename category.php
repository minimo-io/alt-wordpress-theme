<?php get_header(); ?>
<?php get_sidebar(); ?>
<?php
$o_cat = $wp_query->get_queried_object();
$t_category_description = category_description();
$is_readmore = alt_reveal_more_button($t_category_description);
?>
<main id="main" class="site-main" role="main">
	<section class="container primary-container category-container nav-scroller bg-white">

    <header class="alt-post-margins alt-top-title category-header white-back">
			<?php
			$backUrl = esc_attr(home_url());
			if($o_cat->category_parent > 0){
				$backUrl = get_category_link($o_cat->category_parent);
			}
			?>
			<a class="breadcrumb-back-button" href="<?php echo $backUrl; ?>" aria-expanded="true" role="button"><i class="fas fa-reply"></i>&nbsp;<?php _e("back", "altminimo"); ?></a>
      <h1 class="post-title basic-mono category-title" <?php echo ($o_cat->category_parent > 0 ? "style='line-height:1.1rem;'" : "") ?> itemprop="name headline">
				<?php
				if($o_cat->category_parent > 0){
					$parentCat = get_category($o_cat->category_parent);
					echo "<span style='font-size:1rem;'>".$parentCat->name."&nbsp;&raquo;&nbsp;<br></span>";
				}
				?>
				<?php
				$icon = "";
				if (function_exists('get_field')){
					$icon = get_field('fontawesome', $o_cat);
				}
				if ($icon) echo '<i class="'.$icon.'"></i>';
				?>
				<?php single_cat_title(); ?><span class="text-<?php echo alt_tax_color($o_cat); ?>">.</span>
			</h1>
      <h2 class="post-subtitle category-subtitle <?php echo (!empty($is_readmore) ? "read-more" : ""); ?>"><?php echo $t_category_description; ?></h2>
      <?php echo ($is_readmore ? $is_readmore : ""); ?>
			<?php
			$catChildrens = alt_category_has_children($o_cat->term_id);
			if( $catChildrens ){
				// var_dump($catChildrens);
				foreach ( $catChildrens as $category ) {
					$categoryFa = get_field("fontawesome", $category);
					echo '<a role="button" href="'.get_category_link( $category->term_id ).'" class="btn btn-danger btn-category btn-sm btn-readmore sm-btn-block"><i class="'.$categoryFa.' mr-1"></i>'.$category->name.'</a>';
				}
			}
			?>
    </header>
				<?php
				$sticky = get_option( 'sticky_posts' );
				// args
				$args = array(
					'posts_per_page' => 1,
					'post_type'		=> 'post',
					'post__in' => $sticky,
          'category__in' => $o_cat->term_id,
					'ignore_sticky_posts' => 1
				);

				// query
				$the_query = new WP_Query( $args );
				if ( isset( $sticky[0] ) ):
				?>
				<?php if( $the_query->have_posts() ): ?>
					<div id="carousel-homepage" class="carousel slide carousel-featured mt-5" data-ride="carousel">
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
									foreach ($a_post_cats as $cat_key => $cat){

										$badge_color = alt_tax_color($cat);

										$html_cats .= '<a href="'.esc_attr(get_category_link( $cat->term_id )).'" class="badge badge-'.$badge_color.'">'.esc_html($cat->name).'</a>';
									}
									?>
						      <div class="carousel-item <?php echo ($c_carrousel == 0 ? "active" : ""); ?>">
										<a href="<?php the_permalink(); ?>">
											<div class="overlay overlay-<?php echo $badge_color; ?>"></div>
							        <img class="d-block w-100 img-fluid rounded" alt="carousel-image-1" src="<?php echo esc_attr(get_the_post_thumbnail_url()); ?>">

											<div class="card">
		 										 <div class="card-body">
													 		<h5 class="card-title"><?php the_title(); ?></h5>
		 												 <div class="card-text card-excerpt"><?php the_excerpt(); ?></div>
		 												 <div class="card-text card-meta">
		 													 <small class="text-muted">
		 														 <?php echo __("By ", "altminimo").$author_name; ?> &nbsp;
		 														 <?php echo esc_html(get_the_date('j M')); ?>
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




				echo '<div class="card-posts-deck card-group">
								<ul class="card-list row list-unstyled ml-0 mr-0">';
				while ( have_posts() ) :
					the_post();
          if (!in_array(get_the_ID(), $sticky)){
            get_template_part( 'template-parts/post/loop', "loop" );
          }
					?>


			<?php
			endwhile;
			echo '</ul>
				</div>';

			?>
		<div class="alt-pagination text-center">
			<?php alt_pagination(); ?>
		</div>
	</section>
</main><!-- .site-main -->

<?php echo alt_subscription_box(); ?>

<?php get_footer(); ?>
