<?php
/**
 * Alt only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	// require get_template_directory() . '/inc/back-compat.php';
}

require_once(  get_template_directory( __FILE__ ) . '/assets/inc/custom-fields.inc.php' );
require_once(  get_template_directory( __FILE__ ) . '/assets/inc/admin-panel.inc.php' );
require_once(  get_template_directory( __FILE__ ) . '/assets/inc/categories-extra-fields.inc.php' );


if ( ! function_exists( 'alt_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own alt_setup() function to override in a child theme.
	 */
	function alt_setup() {

			$GLOBALS['content_width'] = 900;

		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'altminimo' );

		/*
		 * Load translation files.
		 */
		load_theme_textdomain( 'altminimo', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for custom logo.
		 *
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 68,
				'width'       => 288,
				'flex-height' => true,
			)
		);


		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'altminimo' ),
				'secondary'  => __( 'Secondary Menu', 'altminimo' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */

		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video'
				// 'quote',
				// 'link',
				// 'gallery',
				// 'status',
				// 'audio',
				// 'chat',
			)
		);
		add_post_type_support( 'page', 'excerpt' );
		add_post_type_support( 'page', 'post-formats' ); // for some reason post-formats are not working for pages
		add_post_type_support( 'post', 'post-formats' );

		// Add support for responsive embeds.
		add_theme_support( 'responsive-embeds' );


	}
endif; // alt_setup
add_action( 'after_setup_theme', 'alt_setup' );


if ( ! function_exists( 'alt_post_thumbnail' ) ) :


	// Display the video embedded in the content
	function alt_post_video($content){
		$content = apply_filters( 'the_content', $content );
		$a_content = get_media_embedded_in_content($content);

		if (isset($a_content[0])){
			?>
			<div class="embed-responsive embed-responsive-21by9">
				<?php echo $a_content[0]; ?>
			</div>
			<?php
		}
	}
	// Remove video from the content because it is already on top
	function alt_remove_diplicate_media($content){
		$content = apply_filters( 'the_content', $content );
		$a_content = get_media_embedded_in_content($content);
		$content = strip_tags($content, "<p><br><i><strong><blockquote><div>");
		foreach ($a_content as $a_k => $media){
			//echo $media;
			// $content = str_replace($media, "", $content);
		}
		return $content;
	}
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 *
	 */
	function alt_post_thumbnail($post_format = "standard") {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			$image_id = get_post_thumbnail_id();
			if ($image_id){
					$thumbnail = wp_get_attachment_image_src( $image_id,'full' );
					$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
					$image = get_post(get_post_thumbnail_id());
					if ($post_format == "image"){
						?>
						<div class="post-format-image" style="background-image:url(<?php echo esc_attr($thumbnail[0]);  ?>);"></div>
						<?php if (!empty($image->post_excerpt)){ ?>
							<figcaption class="figure-caption figure-caption-wide text-right"><?php echo esc_html($image->post_excerpt); ?></figcaption>
						<?php } ?>
						<?php
					}else{
						?>
						<center>
							<figure class="figure">
								<div class="post-thumbnail"><picture><img src="<?php echo esc_attr($thumbnail[0]); ?>" class="img-fluid rounded" alt="<?php echo esc_attr($image_alt); ?>"></picture>
								</div>
								<figcaption class="figure-caption text-right"><?php echo esc_html($image->post_excerpt); ?></figcaption>
							</figure>
						</center>
						<?php
					}
			}
			 ?>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
	</a>

		<?php
	endif; // End is_singular()
	}
endif;

/**
 * Define the loop pagination
 *
 */
function alt_pagination(){
	global $wp_query;
	if (!is_single()){
		if (! get_option( "alt_use_default_pagination" )){
			if (  $wp_query->max_num_pages > 1 ) echo '<button class="btn btn-light btn-loadmore"><i class="fas fa-plus"></i></button>';
		}else{
			//wp_link_pages();
			posts_nav_link();
		}
	}else{
		wp_link_pages();
	}
}

/**
 * Get Taxonomy configured color
 *
 * @param array  $o_tax          Taxonomy object
 */
function alt_tax_color( $o_tax ) {
	$badge_color = "primary";
	if (isset($o_tax->term_id)){
		$category_color = get_option( "category_color_".$o_tax->term_id);
		if ($category_color) $badge_color = $category_color;
	}
	return $badge_color;
}



/**
 * Count words of a given text and calculate reading time
 *
 * @param array  $text          String of text
 */
function alt_reading_time( $text ) {

	$word_count = str_word_count(strip_tags($text));
	// $reading_time = $word_count * 0.00389;
	// if ($reading_time < 1) $reading_time = 1;
	// $reading_time = round($reading_time);

	$reading_time = $word_count / 200; // average adult reads 200-250 words per minute
	if ($reading_time < 1) $reading_time = 1;
	$reading_time = round($reading_time);

	return Array('reading_time' => $reading_time, 'word_count' => $word_count);
}

/**
 * Add preconnect for Google Fonts.
 *
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function alt_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentysixteen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'alt_resource_hints', 10, 2 );


/**
 * Enqueues scripts and styles.
 */
function alt_scripts() {

	global $wp_query;

	wp_enqueue_style( 'alt-bootstrap-minimo', get_template_directory_uri()."/assets/css/bootstrap.min.css" );
	wp_enqueue_style( 'alt-animate', get_template_directory_uri()."/assets/css/animate.css" );

	wp_enqueue_style( 'alt-style', 'https://cdn.jsdelivr.net/npm/@minimo-labs/alt-template@0.6.0/dist/alt.min.css', Array( "alt-bootstrap-minimo", "alt-animate"  ), '0.5.5' );
	wp_enqueue_style( 'alt-child-style', get_template_directory_uri()."/style.css", Array( "alt-style" ) );

	wp_enqueue_script( 'alt-html5', get_template_directory_uri() . '/assets/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'alt-html5', 'conditional', 'lt IE 9' );
	wp_enqueue_script( 'alt-popper', get_template_directory_uri() . '/assets/js/popper.min.js', array( 'jquery' ), NULL, true );
	wp_enqueue_script( 'alt-bootstrap', get_template_directory_uri().'/assets/js/bootstrap.min.js', array( 'jquery', 'alt-popper' ), NULL, true );

	// wp_enqueue_script( 'alt-script', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), NULL , true );
	wp_enqueue_script( 'alt-script', 'https://cdn.jsdelivr.net/npm/@minimo-labs/alt-template@0.6.0/dist/alt.min.js', array( 'jquery' ), NULL , true );

	if ( is_singular() ) wp_enqueue_script( "comment-reply" );

	// load more posts
	wp_localize_script( 'alt-script', 'alt_loadmore_params', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ), // WordPress AJAX
		'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $wp_query->max_num_pages
	) );


}
add_action( 'wp_enqueue_scripts', 'alt_scripts' );


/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function alt_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		} else {
			$attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
		}
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'alt_post_thumbnail_sizes_attr', 10, 3 );



function alt_adapt_comment_form( $arg ) {
    // $arg contains all the comment form defaults
    // simply redefine one of the existing array keys to change the comment form
    // see http://codex.wordpress.org/Function_Reference/comment_form for a list
    // of array keys
    // add Foundation classes to the button class
    $arg['class_submit'] = 'btn btn-primary';
    // return the modified array
    return $arg;
}

function alt_remove_posts_from_home_page( $query ) {

  if( $query->is_main_query() && $query->is_home() ) {
		$query->set('post__not_in', get_option( 'sticky_posts' ));
  }
}
function alt_loadmore_ajax_handler(){

	// prepare our arguments for the query
	$args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
	$args['post_status'] = 'publish';
	$args['post__not_in'] = get_option( 'sticky_posts' );

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if( have_posts() ) :

		// run the loop
		while( have_posts() ): the_post();

			// look into your theme code how the posts are inserted, but you can use your own HTML of course
			// do you remember? - my example is adapted for Twenty Seventeen theme
			get_template_part( 'template-parts/post/loop', "loop" );
			// for the test purposes comment the line above and uncomment the below one
			 //the_title();


		endwhile;

	endif;
	die; // here we exit the script and even no wp_reset_query() required!
}

function alt_reveal_more_button($text, $color = ""){
	$is_showmore = false;
	if (strlen($text) > 250) $is_showmore = '<button id="btn-readmore" data-original-height="" data-status="off" data-text-more="'.__("Read more", "altminimo").'" data-text-less="'.__("Read less", "altminimo").'" class="btn btn-'.(!empty($color)? $color : "light" ).' btn-sm btn-readmore">'.__("Read more", "altminimo").'</button>';
	return $is_showmore;
}
// change default excerpt length
add_filter( 'excerpt_length', function($length) {
    return 25;
} );


function alt_content_end( $content ) {

    // Check if we're inside the main loop in a single post page.
    if ( is_single() && in_the_loop() && is_main_query() ) {
        return $content . "<div class='post-content-end'></div>";
    }

    return $content;
}

function aipim_hook_css() {
	if (! is_admin()){
	?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/favs/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favs/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favs/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/favs/site.webmanifest">
	<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favs/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/favs/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/assets/favs/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<?php
	}
}

add_action('wp_head', 'aipim_hook_css');
add_filter( 'the_content', 'alt_content_end' );
add_action('wp_ajax_loadmore', 'alt_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'alt_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}
// run the comment form defaults through the newly defined filter
add_filter( 'comment_form_defaults', 'alt_adapt_comment_form' );
// remove featured post from main query
add_action( 'pre_get_posts', 'alt_remove_posts_from_home_page' );
?>
