<?php
/**
 * Sample wp-config.php configuration for Hub Marketeria Theme
 * 
 * Copy the relevant sections to your wp-config.php file
 * 
 * @package Hub_Marketeria
 */

// =============================================================================
// GEMINI API CONFIGURATION
// =============================================================================

/**
 * Gemini API Key
 * 
 * Required for all AI features:
 * - Business strategy generation
 * - Lead scoring
 * - AI Library personas
 * 
 * Get your API key from: https://aistudio.google.com/app/apikey
 */
define('GEMINI_API_KEY', 'your-gemini-api-key-here');

// Alternatively, you can set it as an environment variable:
// export GEMINI_API_KEY="your-api-key-here"

// =============================================================================
// WORDPRESS CONFIGURATION
// =============================================================================

/**
 * WordPress Database Settings
 * (These are standard WordPress settings)
 */
// define('DB_NAME', 'database_name_here');
// define('DB_USER', 'username_here');
// define('DB_PASSWORD', 'password_here');
// define('DB_HOST', 'localhost');
// define('DB_CHARSET', 'utf8mb4');
// define('DB_COLLATE', '');

// =============================================================================
// DEBUGGING
// =============================================================================

/**
 * For development, you can enable WordPress debugging
 */
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false);

// =============================================================================
// SECURITY SETTINGS
// =============================================================================

/**
 * Authentication Unique Keys and Salts
 * 
 * You can generate these using: https://api.wordpress.org/secret-key/1.1/salt/
 */
// define('AUTH_KEY',         'put your unique phrase here');
// define('SECURE_AUTH_KEY',  'put your unique phrase here');
// define('LOGGED_IN_KEY',    'put your unique phrase here');
// define('NONCE_KEY',        'put your unique phrase here');
// define('AUTH_SALT',        'put your unique phrase here');
// define('SECURE_AUTH_SALT', 'put your unique phrase here');
// define('LOGGED_IN_SALT',   'put your unique phrase here');
// define('NONCE_SALT',       'put your unique phrase here');

// =============================================================================
// OPTIONAL: PERFORMANCE OPTIMIZATION
// =============================================================================

/**
 * Increase memory limit for handling large lead datasets
 */
// define('WP_MEMORY_LIMIT', '256M');

/**
 * Enable caching for better performance
 */
// define('WP_CACHE', true);

// =============================================================================
// OPTIONAL: REST API CUSTOMIZATION
// =============================================================================

/**
 * If you need to customize REST API behavior
 */
// Increase REST API request timeout
// add_filter('http_request_timeout', function() { return 30; });

// =============================================================================
// THEME-SPECIFIC SETTINGS (Optional)
// =============================================================================

/**
 * Custom settings for Hub Marketeria theme
 * These can be added if you want to customize behavior
 */

// Disable automatic lead scoring (if you want to score manually)
// define('HUB_MARKETERIA_AUTO_SCORE', false);

// Set default lead score threshold for high-quality leads
// define('HUB_MARKETERIA_HIGH_SCORE_THRESHOLD', 70);

// Set default lead score threshold for medium-quality leads
// define('HUB_MARKETERIA_MEDIUM_SCORE_THRESHOLD', 40);

// Customize Gemini model (default: gemini-2.0-flash-exp)
// define('HUB_MARKETERIA_GEMINI_MODEL', 'gemini-2.0-flash-exp');

// Enable/disable logging for AI requests
// define('HUB_MARKETERIA_LOG_AI_REQUESTS', true);

// =============================================================================
// END OF CONFIGURATION
// =============================================================================

/**
 * IMPORTANT: After configuring, rename this file to wp-config.php
 * or copy the settings to your existing wp-config.php
 */
