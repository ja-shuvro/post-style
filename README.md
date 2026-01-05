# Post Style - Professional WordPress Plugin

A production-ready WordPress plugin that provides multiple responsive post display styles via shortcodes.

## Features

- **Multiple Display Styles**: List, Card, Grid, Masonry, and Slider layouts
- **Fully Responsive**: Mobile-first design that works on all devices
- **Shortcode-Based**: Easy to use with copy-paste shortcodes
- **Extensible Architecture**: Add new styles without modifying core files
- **Performance Optimized**: Conditional asset loading, efficient queries
- **Translation Ready**: Full i18n support with .pot file
- **Security First**: Proper sanitization, escaping, and validation

## Installation

1. Upload the `post_style` folder to `/wp-content/plugins/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use shortcodes in your posts/pages

## Shortcode Usage

### Basic Usage

```
[post_style]
```

### Advanced Usage

```
[post_style 
    style="card" 
    posts_per_page="6" 
    post_type="post" 
    category="5" 
    columns="3" 
    orderby="date" 
    order="DESC" 
    show_excerpt="yes" 
    excerpt_length="20" 
    show_meta="yes" 
    show_image="yes"
]
```

### Available Attributes

- `style` - Display style: `list`, `card`, `grid`, `masonry`, `slider` (default: `list`)
- `posts_per_page` - Number of posts to display (default: `6`)
- `post_type` - Post type to query (default: `post`)
- `category` - Category ID (default: empty)
- `taxonomy` - Custom taxonomy name
- `tax_term` - Taxonomy term ID
- `orderby` - Order by field: `date`, `title`, `menu_order`, etc. (default: `date`)
- `order` - Sort order: `ASC` or `DESC` (default: `DESC`)
- `columns` - Number of columns for grid/card/masonry (default: `3`)
- `show_excerpt` - Show excerpt: `yes` or `no` (default: `yes`)
- `excerpt_length` - Excerpt word count (default: `20`)
- `show_meta` - Show post meta: `yes` or `no` (default: `yes`)
- `show_image` - Show featured image: `yes` or `no` (default: `yes`)
- `post__in` - Comma-separated post IDs
- `exclude` - Comma-separated post IDs to exclude

## Examples

### Display Latest Posts in Card Style

```
[post_style style="card" posts_per_page="9" columns="3"]
```

### Display Posts from Specific Category in Grid

```
[post_style style="grid" category="5" columns="4" posts_per_page="8"]
```

### Display Custom Post Type in Slider

```
[post_style style="slider" post_type="portfolio" posts_per_page="5"]
```

### Display Posts in Masonry Layout

```
[post_style style="masonry" posts_per_page="12" columns="3"]
```

## Architecture

### Folder Structure

```
post_style/
├── assets/
│   ├── css/
│   │   ├── base.css
│   │   └── styles/
│   │       ├── list.css
│   │       ├── card.css
│   │       ├── grid.css
│   │       ├── masonry.css
│   │       └── slider.css
│   └── js/
│       └── styles/
│           ├── slider.js
│           └── masonry.js
├── includes/
│   ├── class-loader.php
│   ├── class-shortcode-manager.php
│   ├── class-assets-manager.php
│   ├── class-template-renderer.php
│   ├── class-query-builder.php
│   └── helpers.php
├── templates/
│   ├── style-list.php
│   ├── style-card.php
│   ├── style-grid.php
│   ├── style-masonry.php
│   └── style-slider.php
├── languages/
│   └── post-style.pot
├── post-style.php
└── README.md
```

### Core Classes

- **Loader**: Main plugin orchestrator, manages component initialization
- **Shortcode_Manager**: Handles shortcode registration and rendering
- **Assets_Manager**: Manages CSS/JS enqueuing with conditional loading
- **Template_Renderer**: Renders templates for different post styles
- **Query_Builder**: Builds and executes WordPress queries

## Extending the Plugin

### Adding a New Post Style

See `EXTENDING.md` for detailed instructions on adding custom post styles.

### Filters

- `post_style_query_args` - Modify query arguments
- `post_style_shortcode_atts` - Modify shortcode attributes
- `post_style_available_styles` - Add/remove available styles
- `post_style_template_file` - Override template file location
- `post_style_wrapper_classes` - Modify wrapper CSS classes
- `post_style_detected_styles` - Modify detected styles for asset loading

## Requirements

- WordPress 5.8 or higher
- PHP 7.4 or higher

## Security

All user inputs are sanitized and escaped:
- Shortcode attributes are sanitized
- Output is properly escaped
- File paths are validated
- Nonces used where applicable

## Performance

- Conditional asset loading (only loads CSS/JS for used styles)
- Efficient database queries
- Proper use of WordPress caching
- Asset versioning for cache busting

## Translation

The plugin is fully translation-ready. To translate:

1. Copy `languages/post-style.pot` to your language
2. Translate using Poedit or similar tool
3. Save as `post-style-{locale}.po` and compile to `.mo`

## Support

For issues, feature requests, or contributions, please visit the plugin repository.

## License

GPL-2.0+

## Changelog

### 1.0.0
- Initial release
- List, Card, Grid, Masonry, and Slider styles
- Full shortcode support
- Responsive design
- Translation ready

