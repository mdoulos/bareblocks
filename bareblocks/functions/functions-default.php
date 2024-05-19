<?php 

add_action('after_setup_theme', 'bareblocks_setup');
function bareblocks_setup()
{
    load_theme_textdomain('bareblocks', get_template_directory() . '/languages');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'navigation-widgets'
    ));
    add_theme_support('woocommerce');

    global $content_width;
    if (!isset($content_width)) {
        $content_width = 1400;
    }

    register_nav_menus(array(
        'desktop-navigation' => esc_html__('Desktop Navigation', 'bareblocks'),
        'mobile-navigation' => esc_html__('Mobile Navigation', 'bareblocks'),
        'footer-navigation' => esc_html__('Footer Navigation', 'bareblocks'),
    ));
}

add_action("wp_enqueue_scripts", "bareblocks_enqueue");
function bareblocks_enqueue() {
    wp_enqueue_style( 'default-style', get_template_directory_uri() . '/css/style-default.css', array(), '1.0.0', 'all' );
    wp_enqueue_style( 'primary-style', get_template_directory_uri() . '/css/style-primary.css', array('default-style'), '1.0.0', 'all' );

    wp_enqueue_script("jquery");
}

add_filter('document_title_separator', 'bareblocks_document_title_separator');
function bareblocks_document_title_separator($sep) {
    $sep = esc_html('|');
    return $sep;
}

add_filter('the_title', 'bareblocks_title');
function bareblocks_title($title) {
    if ($title == '') {
        return esc_html('...');
    }
    else {
        return wp_kses_post($title);
    }
}

function bareblocks_schema_type() {
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    }
    elseif (is_author()) {
        $type = 'ProfilePage';
    }
    elseif (is_search()) {
        $type = 'SearchResultsPage';
    }
    else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}

add_filter('nav_menu_link_attributes', 'bareblocks_schema_url', 10);
function bareblocks_schema_url($atts) {
    $atts['itemprop'] = 'url';
    return $atts;
}

if (!function_exists('bareblocks_wp_body_open')) {
    function bareblocks_wp_body_open() {
        do_action('wp_body_open');
    }
}

add_action('wp_body_open', 'bareblocks_skip_link', 5);
function bareblocks_skip_link() {
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'bareblocks') . '</a>';
}

add_filter('the_content_more_link', 'bareblocks_read_more_link');
function bareblocks_read_more_link() {
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'bareblocks') , '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

add_filter('excerpt_more', 'bareblocks_excerpt_read_more_link');
function bareblocks_excerpt_read_more_link($more) {
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'bareblocks') , '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}

add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'bareblocks_image_insert_override');
function bareblocks_image_insert_override($sizes) {
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}

add_action('widgets_init', 'bareblocks_widgets_init');
function bareblocks_widgets_init() {
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'bareblocks') ,
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('wp_head', 'bareblocks_pingback_header');
function bareblocks_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}

add_action('comment_form_before', 'bareblocks_enqueue_comment_reply_script');
function bareblocks_enqueue_comment_reply_script() {
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function bareblocks_custom_pings($comment) { ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php }

add_filter('get_comments_number', 'bareblocks_comment_count', 0);
function bareblocks_comment_count($count) {
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    }
    else {
        return $count;
    }
}

