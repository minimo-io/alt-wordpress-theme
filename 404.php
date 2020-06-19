<?php get_header(); ?>
<?php get_sidebar(); ?>

<main id="main" class="site-main" role="main">
	<section id="sec-ethos" class="container main-container category-container">
        <div class="nav-scroller bg-white">
					<div class="container second-container">
            <header class="alt-post-margins alt-top-title notfound-header white-back">
              <a class="breadcrumb-back-button" href="<?php echo esc_attr(home_url()); ?>" aria-expanded="true" role="button"><i class="fas fa-reply"></i>&nbsp;<?php _e("back", "altminimo"); ?></a>
              <h1 class="post-title basic-mono category-title" itemprop="name headline"><?php _e("Ups! Page not found.", "altminimo"); ?><span class="text-<?php echo alt_tax_color($o_cat); ?>">.</span></h1>
              <h2 class="post-subtitle category-subtitle"><?php _e("Looks that there is nothing here. Maybe try a search?<br><br>Meanwhile you might be interested in some of these articles.", "altminimo"); ?></h2>
            </header>
            <?php
            get_template_part( 'template-parts/post/none', 'none' );
            ?>
          </div>
        </div>
  </section>
</main>
<?php get_footer(); ?>
