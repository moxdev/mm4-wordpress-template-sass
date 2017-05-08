<?php
/**
 * MM4 You functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package MM4 You
 */

if ( ! function_exists( 'mm4_you_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mm4_you_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MM4 You, use a find and replace
	 * to change 'mm4-you' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'mm4-you', get_template_directory() . '/languages' );

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
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('blog-feature', 200, 200, true);
	add_image_size('front-page-slide-1', 1400, 535, true);
	add_image_size('front-page-slide-2', 1400, 800, true);
	add_image_size('gallery-main', 1400, 950, true);
	add_image_size('gallery-thumb', 300, 200, true);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'mm4-you' ),
		'footer' => esc_html__( 'Footer Menu', 'mm4-you'),
		'aux' => esc_html__( 'Aux Menu', 'mm4-you'),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	/*add_theme_support( 'custom-background', apply_filters( 'mm4_you_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );*/
}
endif; // mm4_you_setup
add_action( 'after_setup_theme', 'mm4_you_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mm4_you_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mm4_you_content_width', 640 );
}
add_action( 'after_setup_theme', 'mm4_you_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mm4_you_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Global Sidebar', 'mm4_you' ),
		'id'            => 'sidebar-global',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'mm4_you' ),
		'id'            => 'sidebar-blog',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'mm4_you_widgets_init' );

function register_jquery()  {
	if (!is_admin()) {
		wp_deregister_script('jquery');
        // Load the copy of jQuery that comes with WordPress
        // The last parameter set to TRUE states that it should be loaded in the footer.
        wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', FALSE, '1.11.2', TRUE);
    }
}
add_action('init', 'register_jquery');

/**
 * Enqueue scripts and styles.
 */
function mm4_you_scripts() {
	wp_enqueue_style( 'mm4-you-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mm4-you-navigation', get_template_directory_uri() . '/js/min/navigation-min.js', array('jquery'), '20120206', true );

	if(is_page_template('page-contact.php')) {
		wp_enqueue_script( 'mm4-you-google-map-api', 'http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDqcS80RSqBcZepAEhhxKHkSzYLZeNI0Ho', array(), '', true );
		// wp_enqueue_script( 'mm4-you-validate-lib', get_template_directory_uri() . '/js/validate.min.js', array('jquery'), '20150904', true );
		wp_enqueue_script( 'mm4-you-directions', get_template_directory_uri() . '/js/min/map-directions-min.js', array('jquery', 'mm4-you-google-map-api'), '20150904', true );
		// wp_enqueue_script( 'mm4-you-main-form-validate', get_template_directory_uri() . '/js/form-main-validate.js', array('jquery', 'mm4-you-validate-lib'), '20150826', true );
	}

	if( is_page_template('frontpage-a.php') || is_page_template('frontpage-b.php') || is_page_template('frontpage-c.php') ) {
		if( function_exists('get_field') ) {
			if( have_rows('slides') ) {
				wp_enqueue_script( 'mm4-you-images-loaded', get_template_directory_uri() . '/js/min/jquery.imagesloaded.min.js', array('jquery'), '20150908', true );
				wp_enqueue_script( 'mm4-you-image-fill', get_template_directory_uri() . '/js/min/jquery-imagefill.min.js', array('jquery', 'mm4-you-images-loaded'), '20150908', true );
				wp_enqueue_script( 'mm4-you-touchswipe', get_template_directory_uri() . '/js/min/jquery.touchSwipe.min.js', array('jquery'), '20150908', true );
				wp_enqueue_script( 'mm4-you-home-carousel', get_template_directory_uri() . '/js/min/home-carousel-min.js', array('jquery', 'mm4-you-images-loaded', 'mm4-you-image-fill', 'mm4-you-touchswipe'), '20150908', true );
			}
		}
	}

	if( is_page_template('page-photo-gallery.php') ) {
		if( function_exists('get_field') ) {
			if( have_rows('images') ) {
				wp_enqueue_script( 'mm4-you-images-loaded', get_template_directory_uri() . '/js/min/jquery.imagesloaded.min.js', array('jquery'), '20150908', true );
				wp_enqueue_script( 'mm4-you-image-fill', get_template_directory_uri() . '/js/min/jquery-imagefill.min.js', array('jquery', 'mm4-you-images-loaded'), '20150908', true );
				wp_enqueue_script( 'mm4-you-touchswipe', get_template_directory_uri() . '/js/min/jquery.touchSwipe.min.js', array('jquery'), '20150908', true );
				wp_enqueue_script( 'mm4-you-gallery', get_template_directory_uri() . '/js/min/photo-gallery-min.js', array('jquery', 'mm4-you-images-loaded', 'mm4-you-image-fill', 'mm4-you-touchswipe'), '20150908', true );
			}
		}
	}

	wp_enqueue_script( 'mm4-you-skip-link-focus-fix', get_template_directory_uri() . '/js/min/skip-link-focus-fix-min.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mm4_you_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load the MM4 contact form plugin.
 */
include_once( get_stylesheet_directory() . '/plugins/mm4-you-contact-form/mm4-you-cf.php' );

/**
 * BLOG CUSTOMIZATIONS
 */

function mm4_you_modify_read_more_link() {
	return '<a class="more-link" href="' . get_permalink() . '">Read more &raquo;</a>';
}

add_filter( 'the_content_more_link', 'mm4_you_modify_read_more_link' );

/**
 * PAGE SUBNAV
 */

function mm4_you_page_subnav() {
	global $post;
	$parent = array_reverse(get_post_ancestors($post->ID));
	$first_parent = get_page($parent[0]);
	$children = get_pages('child_of='.$first_parent->ID);
	if( count( $children ) != 0 ) {?>
    <div class="subnav-wrapper">
        <nav class="subnav" id="sidebar-subnav">
            <ul>
            <?php wp_list_pages('child_of=' . $first_parent->ID . '&title_li=&sort_column=menu_order'); ?>
            </ul>
        </nav>
    </div>
	<?php }
}

/**
 * SIDEBAR CUSTOM WYSIWYG
 */

function mm4_you_sidebar_wysiwyg() {
	if( function_exists('get_field') ) {
		$sideWYSIWYG = get_field('sidebar_text');
		if($sideWYSIWYG) { ?>
			<aside id="custom-sidebar-wysiwyg">
				<?php echo $sideWYSIWYG; ?>
			</aside>
		<?php }
	}
}

function mm4_you_contact_page_sidebar() {
	if(is_page_template('page-contact.php')) {
		$add = get_theme_mod('setting_address');
		$city = get_theme_mod('setting_city');
		$state = get_theme_mod('setting_state');
		$zip = get_theme_mod('setting_zip');
		$ph = get_theme_mod('setting_phone');
		$fx = get_theme_mod('setting_fax');
		$email = get_theme_mod('setting_email');
		$hours1 = get_theme_mod('setting_hours_1');
		$hours2 = get_theme_mod('setting_hours_2');
		$hours3 = get_theme_mod('setting_hours_3');

		if($hours1 || $hours2 || $hours3) { ?>
			<aside id="office-hours">
				<h2>Office Hours</h2>
				<?php if($hours1): ?><span class="hours" id="side-hours-1"><?php echo $hours1; ?></span><?php endif;
				 if($hours2): ?><span class="hours" id="side-hours-2"><?php echo $hours2; ?></span><?php endif;
				 if($hours3): ?><span class="hours" id="side-hours-3"><?php echo $hours3; ?></span><?php endif; ?>
			</aside>
		<?php }

		if($add || $city || $state || $zip || $ph || $fx || $email) { ?>
			<aside id="address-phone">
				<h2>Address/Phone</h2>
				<?php if($add): ?><span class="side-contact" id="side-address-1"><?php echo $add; ?></span><?php endif;
				if($city): ?><span class="side-contact" id="side-city"><?php echo $city; ?></span><?php endif; if($city || $state || $zip): ?><span class="comma">, </span><?php endif; if($state): ?><span class="side-contact" id="side-state"><?php echo $state; ?> </span><?php endif; if($zip): ?><span class="side-contact" id="side-zip"><?php echo $zip; ?></span><?php endif;
				if($ph): ?><span class="side-contact" id="side-phone"><a href="tel:<?php echo $ph; ?>" class="tel"><?php echo $ph; ?></a></span><?php endif;
				if($fx): ?><span class="side-contact" id="side-fax"><a href="fax:<?php echo $fx; ?>" class="tel"><?php echo $fx; ?></a></span><?php endif;
				if($email): ?><span class="side-contact" id="side-email"><a href="mailto:<?php echo $email; ?>" target="_blank"><?php echo $email; ?></a></span><?php endif; ?>
			</aside>
		<?php } ?>

		<aside id="directions">
			<h2>Get Directions</h2>
			<div id="side-map-canvas" class="map-canvas"></div>
			<form id="form-directions" onSubmit="calcRoute(); return false;">
				<label for="start">Starting Address</label>
				<input type="text" id="start" name="start">
				<input type="hidden" id="end" name="end" value="<?php echo $add . ', ' . $city . ', ' . $state . ' ' . $zip; ?>">
				<div class="error-box" id="map-error"></div>
				<input type="button" onclick="calcRoute();" value="Get Directions" class="btn">
			</form>
			<div id="directions-panel"></div>
		</aside>

	<?php }
}

function mm4_you_contact_page_build_map() {
	$name = get_theme_mod('setting_name');
	$lat = get_theme_mod('setting_latitude');
	$lng = get_theme_mod('setting_longitude');
	$add = get_theme_mod('setting_address');
	$city = get_theme_mod('setting_city');
	$state = get_theme_mod('setting_state');
	$zip = get_theme_mod('setting_zip');
	if( is_page_template('page-contact.php') ) {
		if( $name || $lat || $lng || $add || $city || $state || $zip ) { ?>
		<script>
			var locations = [
				["<?php echo $name; ?>", <?php echo $lat; ?>, <?php echo $lng; ?>, "<?php echo $add; ?>", "<?php echo $city . ', ' . $state . ' ' . $zip; ?>"]
			]
		</script>
		<?php }
	}
}

add_action('wp_footer', 'mm4_you_contact_page_build_map');

/**
 * FRONT PAGE
 */

function mm4_you_home_carousel_body_class( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_page_template('frontpage-a.php') || is_page_template('frontpage-b.php') || is_page_template('frontpage-c.php') && function_exists('get_field') ) {
		if( get_field('add_image_carousel') == 'Yes' )
		$classes[] = 'has-carousel';
	}

	return $classes;
}
add_filter( 'body_class', 'mm4_you_home_carousel_body_class' );


function mm4_you_home_carousel_type_1() {
	if( is_page_template('frontpage-a.php') || is_page_template('frontpage-b.php') ) {
		if( function_exists('get_field') ) {
			$addCarousel = get_field('add_image_carousel');
			if( $addCarousel == 'Yes' && have_rows('slides') ): ?>
				<div id="home-carousel" class="carousel-type-1">
					<ul>
					<?php while ( have_rows('slides') ) : the_row(); ?>
						<li>
						<?php $text = get_sub_field('slide_caption');
						$imageArr = get_sub_field('slide_image');
						$image = wp_get_attachment_image_src($imageArr[id], 'front-page-slide-1'); ?>
						<img src="<?php echo $image[0] ?>" alt="<?php echo $imageArr[title]; ?>">
						<span><?php echo $text; ?></span>
						</li>
					<?php endwhile; ?>
					</ul>
					<?php $rows = get_field('slides');
					$rowCount = count($rows); ?>
					<ol class="carousel-nav">
					<?php for ($i = 1; $i <= $rowCount; $i++) { ?>
						<li><a href="#"><?php echo $i; ?></a></li>
					<?php } ?>
					</ol>
				</div>
			<?php endif;
		}
	}
}

function mm4_you_home_carousel_type_2() {
	if( is_page_template('frontpage-c.php') ) {
		if( function_exists('get_field') ) {
			$addCarousel = get_field('add_image_carousel');
			if( $addCarousel == 'Yes' && have_rows('slides') ): ?>
				<div id="home-carousel" class="carousel-type-2">
					<ul>
					<?php while ( have_rows('slides') ) : the_row(); ?>
						<li>
						<?php $imageArr = get_sub_field('slide_image');
						$image = wp_get_attachment_image_src($imageArr[id], 'front-page-slide-2'); ?>
						<img src="<?php echo $image[0] ?>" alt="<?php echo $imageArr[title]; ?>">
						</li>
					<?php endwhile; ?>
					</ul>
				</div>
			<?php endif;
		}
	}
}

function mm4_you_home_carousel_type_2_controls() {
	if( is_page_template('frontpage-c.php') ) {
		if( function_exists('get_field') ) {
			$addCarousel = get_field('add_image_carousel');
			if( $addCarousel == 'Yes' && have_rows('slides') ):
				$rows = get_field('slides');
				$rowCount = count($rows); ?>
				<ol class="carousel-nav">
				<?php for ($i = 1; $i <= $rowCount; $i++) { ?>
					<li><a href="#"><?php echo $i; ?></a></li>
				<?php } ?>
				</ol>
		<?php endif;
		}
	}
}

function mm4_you_highlight_boxes() {
	if(is_page_template('frontpage-a.php') || is_page_template('frontpage-b.php') ) {
		if( function_exists('get_field') ) {
			$rows = get_field('highlights');
			$rowCount = count($rows);
			$addHighlights = get_field('add_highlight_boxes');
			if( $addHighlights == 'Yes' && have_rows('highlights') ): ?>
				<div id="home-highlight-wrapper" class="highlight-<?php echo $rowCount; ?>">
					<div id="home-highlight-inner-wrapper">
						<?php while( have_rows('highlights') ): the_row();
						$title = get_sub_field('highlight_title');
						$desc = get_sub_field('highlight_description');
						$linkTxt = get_sub_field('highlight_link_text');
						$url = get_sub_field('highlight_url'); ?>
							<div class="home-highlight">
								<?php if($title): ?><span class="highlight-title"><?php echo $title; ?></span><?php endif; echo "\n";
								if($desc): ?><span class="highlight-desc"><?php echo $desc; ?></span><?php endif; echo "\n";
								if($url): ?><span class="highlight-url"><a href="<?php echo $url; ?>"><?php if($linkTxt): echo $linkTxt . ' &raquo;'; else: ?>Learn More &raquo;<?php endif; ?></a></span><?php endif; echo "\n"; ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
			<?php endif;
		}
	}
}

/**
 * PHOTO GALLERY
 */

function mm4_you_photo_gallery() {
	if( is_page_template('page-photo-gallery.php') ) {
		if( function_exists('get_field') ) {
			if( have_rows('images') ): ?>
				<div id="gallery-main">
					<ul>
					<?php while ( have_rows('images') ) : the_row(); ?>
						<li>
						<?php $imageArr = get_sub_field('gallery_image');
						$image = wp_get_attachment_image_src($imageArr[id], 'gallery-main'); ?>
						<img src="<?php echo $image[0] ?>" alt="<?php echo $imageArr[alt]; ?>">
						</li>
					<?php endwhile; ?>
					</ul>
					<button class="carousel-btn" id="prev" aria-controls="galery-main" aria-label="Previous">Previous</button>
					<button class="carousel-btn" id="next" aria-controls="gallery-main" aria-label="Next">Next</button>
				</div>
			<?php endif;
			if( have_rows('images') ): ?>
				<div id="gallery-thumbs">
					<ul>
					<?php while ( have_rows('images') ) : the_row(); ?>
						<li><a href="#">
						<?php $imageArr = get_sub_field('gallery_image');
						$image = wp_get_attachment_image_src($imageArr[id], 'gallery-thumb'); ?>
						<img src="<?php echo $image[0] ?>" alt="<?php echo $imageArr[title]; ?>">
						</a></li>
					<?php endwhile; ?>
					</ul>
				</div>
			<?php endif;
		}
	}
}