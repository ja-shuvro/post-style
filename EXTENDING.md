# Extending Post Style Plugin

This guide explains how to add new post display styles to the plugin without modifying core files.

## Method 1: Using Filters (Recommended)

Add a new style using WordPress filters in your theme's `functions.php` or a custom plugin.

### Step 1: Register Your Style

```php
add_filter( 'post_style_available_styles', 'my_custom_post_styles' );

function my_custom_post_styles( $styles ) {
    $styles['compact'] = __( 'Compact', 'your-textdomain' );
    return $styles;
}
```

### Step 2: Override Template Location

```php
add_filter( 'post_style_template_file', 'my_custom_template_file', 10, 2 );

function my_custom_template_file( $template_file, $style ) {
    if ( 'compact' === $style ) {
        $template_file = get_stylesheet_directory() . '/post-style-templates/style-compact.php';
    }
    return $template_file;
}
```

### Step 3: Create Template File

Create `wp-content/themes/your-theme/post-style-templates/style-compact.php`:

```php
<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="post-style-compact-list">
    <?php
    while ( $query->have_posts() ) :
        $query->the_post();
        ?>
        <div class="post-style-compact-item">
            <a href="<?php echo esc_url( get_permalink() ); ?>">
                <?php echo esc_html( get_the_title() ); ?>
            </a>
            <span class="post-style-compact-date">
                <?php echo esc_html( get_the_date() ); ?>
            </span>
        </div>
    <?php endwhile; ?>
</div>
```

### Step 4: Enqueue Custom CSS/JS

```php
add_filter( 'post_style_detected_styles', 'my_custom_detect_style', 10, 2 );

function my_custom_detect_style( $styles, $content ) {
    if ( strpos( $content, 'style="compact"' ) !== false ) {
        $styles[] = 'compact';
    }
    return $styles;
}

add_action( 'wp_enqueue_scripts', 'my_custom_post_style_assets' );

function my_custom_post_style_assets() {
    global $post;
    
    if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'post_style' ) ) {
        if ( strpos( $post->post_content, 'style="compact"' ) !== false ) {
            wp_enqueue_style(
                'post-style-compact',
                get_stylesheet_directory_uri() . '/css/post-style-compact.css',
                array( 'post-style-base' ),
                '1.0.0'
            );
        }
    }
}
```

## Method 2: Direct Plugin Extension

Create a separate plugin that extends Post Style.

### Example Extension Plugin

```php
<?php
/**
 * Plugin Name: Post Style - Compact Extension
 * Description: Adds compact style to Post Style plugin
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Post_Style_Compact_Extension {
    
    public function __construct() {
        add_filter( 'post_style_available_styles', array( $this, 'add_compact_style' ) );
        add_filter( 'post_style_template_file', array( $this, 'override_template' ), 10, 2 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }
    
    public function add_compact_style( $styles ) {
        $styles['compact'] = __( 'Compact', 'post-style-compact' );
        return $styles;
    }
    
    public function override_template( $template_file, $style ) {
        if ( 'compact' === $style ) {
            $template_file = plugin_dir_path( __FILE__ ) . 'templates/style-compact.php';
        }
        return $template_file;
    }
    
    public function enqueue_assets() {
        if ( $this->is_compact_style_used() ) {
            wp_enqueue_style(
                'post-style-compact',
                plugin_dir_url( __FILE__ ) . 'assets/css/compact.css',
                array( 'post-style-base' ),
                '1.0.0'
            );
        }
    }
    
    private function is_compact_style_used() {
        global $post;
        return is_a( $post, 'WP_Post' ) && 
               has_shortcode( $post->post_content, 'post_style' ) &&
               strpos( $post->post_content, 'style="compact"' ) !== false;
    }
}

new Post_Style_Compact_Extension();
```

## Method 3: Child Theme Integration

Place your custom templates in your child theme:

1. Create `wp-content/themes/your-child-theme/post-style-templates/`
2. Add your template files (e.g., `style-compact.php`)
3. Use the `post_style_template_file` filter to point to your templates

## Best Practices

1. **Namespace Your Code**: Use unique function/class names to avoid conflicts
2. **Follow WordPress Standards**: Use proper sanitization and escaping
3. **Use Filters**: Don't modify core plugin files
4. **Document Your Code**: Add comments explaining your customizations
5. **Test Thoroughly**: Ensure your custom style works on all devices
6. **Version Your Assets**: Use version numbers for CSS/JS cache busting

## Available Filters Reference

- `post_style_query_args` - Modify WP_Query arguments
- `post_style_shortcode_atts` - Modify shortcode attributes
- `post_style_available_styles` - Add/remove available styles
- `post_style_template_file` - Override template file location
- `post_style_wrapper_classes` - Modify wrapper CSS classes
- `post_style_detected_styles` - Modify detected styles for asset loading

## Example: Complete Custom Style

See the `examples/` directory for a complete example of adding a new style.

