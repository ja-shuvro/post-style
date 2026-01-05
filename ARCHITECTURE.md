# Post Style Plugin - Architecture Documentation

## Overview

This plugin follows enterprise-level WordPress development practices with a modular, scalable, and extensible architecture designed to handle 100,000+ websites.

## Architecture Principles

### 1. Separation of Concerns
Each component has a single, well-defined responsibility:
- **Loader**: Orchestrates plugin initialization
- **Shortcode_Manager**: Handles shortcode registration and rendering
- **Assets_Manager**: Manages CSS/JS enqueuing
- **Template_Renderer**: Renders templates
- **Query_Builder**: Builds and executes queries

### 2. Object-Oriented Design
- PHP namespaces (`PostStyle\Core`) prevent naming conflicts
- Singleton pattern for Loader ensures single instance
- Dependency injection for loose coupling
- Type hints for better IDE support and error prevention

### 3. WordPress Coding Standards
- Follows WordPress PHP Coding Standards
- Proper escaping and sanitization
- Security-first approach
- Translation-ready with i18n

### 4. Performance Optimization
- Conditional asset loading (only loads what's used)
- Efficient database queries
- Proper use of WordPress caching
- Asset versioning for cache busting

## Folder Structure Explanation

```
post_style/
├── assets/                    # Frontend assets
│   ├── css/
│   │   ├── base.css          # Shared base styles
│   │   └── styles/           # Style-specific CSS
│   └── js/
│       └── styles/           # Style-specific JavaScript
│
├── includes/                  # Core PHP classes
│   ├── class-loader.php      # Main plugin loader
│   ├── class-shortcode-manager.php
│   ├── class-assets-manager.php
│   ├── class-template-renderer.php
│   ├── class-query-builder.php
│   └── helpers.php           # Utility functions
│
├── templates/                # Template files for each style
│   ├── style-list.php
│   ├── style-card.php
│   ├── style-grid.php
│   ├── style-masonry.php
│   └── style-slider.php
│
├── languages/                # Translation files
│   └── post-style.pot
│
├── post-style.php           # Main plugin file
├── README.md                # User documentation
├── EXTENDING.md             # Developer documentation
└── ARCHITECTURE.md          # This file
```

## Why This Structure?

### Industry Standard WordPress Plugin Structure

1. **Main Plugin File** (`post-style.php`)
   - Minimal bootstrap code
   - Defines constants
   - Initializes loader
   - Follows WordPress plugin header standards

2. **Includes Directory**
   - Separates core logic from templates
   - Easy to locate and maintain classes
   - Follows WordPress convention

3. **Templates Directory**
   - Separates presentation from logic
   - Easy to override in themes
   - Clear organization by style

4. **Assets Directory**
   - Organized by type (CSS/JS)
   - Subdirectories for style-specific files
   - Easy to manage and version

5. **Languages Directory**
   - Standard WordPress location for translations
   - Easy for translators to find

## Class Responsibilities

### Loader Class
- **Purpose**: Main orchestrator
- **Responsibilities**:
  - Load dependencies
  - Initialize components
  - Register WordPress hooks
  - Manage plugin lifecycle

### Shortcode_Manager Class
- **Purpose**: Handle shortcode functionality
- **Responsibilities**:
  - Register shortcode
  - Sanitize attributes
  - Render shortcode output
  - Handle edge cases (no posts)

### Assets_Manager Class
- **Purpose**: Manage frontend assets
- **Responsibilities**:
  - Enqueue base CSS
  - Detect used styles in content
  - Conditionally load style-specific assets
  - Optimize performance

### Template_Renderer Class
- **Purpose**: Render post display templates
- **Responsibilities**:
  - Locate template files
  - Validate styles
  - Generate wrapper HTML
  - Apply filters for extensibility

### Query_Builder Class
- **Purpose**: Build WordPress queries
- **Responsibilities**:
  - Convert shortcode atts to query args
  - Handle taxonomies
  - Apply filters
  - Execute queries

## Security Implementation

### Input Sanitization
- All shortcode attributes sanitized
- File paths validated
- Text fields escaped
- Numbers validated with `absint()`

### Output Escaping
- All output properly escaped
- `esc_url()` for URLs
- `esc_html()` for text
- `esc_attr()` for attributes
- `wp_kses_post()` for HTML

### File Access
- `ABSPATH` checks prevent direct access
- Template files validated before inclusion
- Asset paths sanitized

## Extensibility Points

### Filters
1. `post_style_query_args` - Modify queries
2. `post_style_shortcode_atts` - Modify attributes
3. `post_style_available_styles` - Add/remove styles
4. `post_style_template_file` - Override templates
5. `post_style_wrapper_classes` - Modify CSS classes
6. `post_style_detected_styles` - Modify asset detection

### Actions
- Standard WordPress hooks available
- Plugin lifecycle hooks (activation/deactivation)

## Performance Considerations

### Asset Loading
- Base CSS always loaded (minimal)
- Style-specific CSS only when style is used
- JavaScript only for interactive styles (slider)
- Conditional detection from post content

### Database Queries
- Single query per shortcode
- Proper use of `WP_Query`
- No N+1 query problems
- Efficient taxonomy queries

### Caching
- Compatible with WordPress object cache
- Query results can be cached
- Asset versioning for browser caching

## Scalability Features

### Modular Design
- Easy to add new styles
- Components can be extended independently
- No tight coupling between classes

### Filter System
- Extensive filter hooks
- Easy customization without core modification
- Theme/plugin compatibility

### Template System
- Templates can be overridden
- Theme integration support
- Child theme friendly

## Best Practices Implemented

1. **WordPress Standards**
   - Follows WordPress Coding Standards
   - Uses WordPress functions and APIs
   - Proper hook usage

2. **Security**
   - Input sanitization
   - Output escaping
   - File access protection

3. **Performance**
   - Conditional asset loading
   - Efficient queries
   - Minimal overhead

4. **Maintainability**
   - Clear code structure
   - Comprehensive documentation
   - Extensible architecture

5. **Internationalization**
   - All strings translatable
   - Proper text domain usage
   - .pot file included

## Future-Proofing

### Version Management
- Constants for version numbers
- Asset versioning for cache busting
- Easy to update

### Backward Compatibility
- Filter system allows old code to work
- Graceful degradation
- No breaking changes in structure

### Extension Support
- Well-documented extension points
- Example code provided
- Community-friendly architecture

## Testing Considerations

### Unit Testing
- Classes are testable (dependency injection)
- Methods have single responsibilities
- Mockable dependencies

### Integration Testing
- WordPress hooks properly registered
- Shortcode rendering works
- Asset loading functions correctly

### Browser Testing
- Responsive design tested
- Cross-browser compatibility
- Mobile-first approach

## Deployment Checklist

- [ ] All files follow WordPress standards
- [ ] Security checks pass
- [ ] Performance optimized
- [ ] Translations included
- [ ] Documentation complete
- [ ] Tested on latest WordPress
- [ ] Tested with various themes
- [ ] Tested on mobile devices
- [ ] Asset versioning configured
- [ ] .gitignore configured

