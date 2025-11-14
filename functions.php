<?php
/**
 * Hub Marketeria Theme Functions
 * 
 * @package Hub_Marketeria
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function hub_marketeria_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'hub-marketeria'),
    ));
}
add_action('after_setup_theme', 'hub_marketeria_setup');

/**
 * Enqueue Scripts and Styles
 */
function hub_marketeria_enqueue_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('hub-marketeria-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Enqueue Alpine.js for lightweight interactivity
    wp_enqueue_script('alpinejs', 'https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js', array(), '3.0.0', true);
    wp_script_add_data('alpinejs', 'defer', true);
    
    // Enqueue SortableJS for Kanban drag and drop
    wp_enqueue_script('sortablejs', 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', array(), '1.15.0', true);
    
    // Enqueue main JavaScript
    wp_enqueue_script('hub-marketeria-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'alpinejs'), '1.0.0', true);
    
    // Localize script for AJAX
    wp_localize_script('hub-marketeria-main', 'hubMarketeria', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hub_marketeria_nonce'),
        'restUrl' => rest_url(),
        'restNonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('wp_enqueue_scripts', 'hub_marketeria_enqueue_scripts');

/**
 * Enqueue Admin Scripts and Styles
 */
function hub_marketeria_enqueue_admin_scripts($hook) {
    // Only load on our custom admin pages
    if ($hook !== 'toplevel_page_hub-marketeria-funnel') {
        return;
    }
    
    wp_enqueue_style('hub-marketeria-style', get_stylesheet_uri(), array(), '1.0.0');
    wp_enqueue_script('sortablejs', 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js', array(), '1.15.0', true);
    wp_enqueue_script('hub-marketeria-admin', get_template_directory_uri() . '/assets/js/admin.js', array('jquery', 'sortablejs'), '1.0.0', true);
    
    wp_localize_script('hub-marketeria-admin', 'hubMarketeria', array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('hub_marketeria_nonce'),
        'restUrl' => rest_url(),
        'restNonce' => wp_create_nonce('wp_rest')
    ));
}
add_action('admin_enqueue_scripts', 'hub_marketeria_enqueue_admin_scripts');

/**
 * Register Custom Post Type: Workflows
 */
function hub_marketeria_register_workflow_cpt() {
    $labels = array(
        'name'               => _x('Workflows', 'post type general name', 'hub-marketeria'),
        'singular_name'      => _x('Workflow', 'post type singular name', 'hub-marketeria'),
        'menu_name'          => _x('Workflows', 'admin menu', 'hub-marketeria'),
        'add_new'            => _x('Add New', 'workflow', 'hub-marketeria'),
        'add_new_item'       => __('Add New Workflow', 'hub-marketeria'),
        'edit_item'          => __('Edit Workflow', 'hub-marketeria'),
        'new_item'           => __('New Workflow', 'hub-marketeria'),
        'view_item'          => __('View Workflow', 'hub-marketeria'),
        'search_items'       => __('Search Workflows', 'hub-marketeria'),
        'not_found'          => __('No workflows found', 'hub-marketeria'),
        'not_found_in_trash' => __('No workflows found in Trash', 'hub-marketeria'),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'workflow'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-networking',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );
    
    register_post_type('workflow', $args);
}
add_action('init', 'hub_marketeria_register_workflow_cpt');

/**
 * Register Custom Taxonomy: Workflow Category
 */
function hub_marketeria_register_workflow_taxonomy() {
    $labels = array(
        'name'              => _x('Workflow Categories', 'taxonomy general name', 'hub-marketeria'),
        'singular_name'     => _x('Workflow Category', 'taxonomy singular name', 'hub-marketeria'),
        'search_items'      => __('Search Categories', 'hub-marketeria'),
        'all_items'         => __('All Categories', 'hub-marketeria'),
        'edit_item'         => __('Edit Category', 'hub-marketeria'),
        'update_item'       => __('Update Category', 'hub-marketeria'),
        'add_new_item'      => __('Add New Category', 'hub-marketeria'),
        'new_item_name'     => __('New Category Name', 'hub-marketeria'),
        'menu_name'         => __('Categories', 'hub-marketeria'),
    );
    
    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'workflow-category'),
        'show_in_rest'      => true,
    );
    
    register_taxonomy('workflow_category', array('workflow'), $args);
}
add_action('init', 'hub_marketeria_register_workflow_taxonomy');

/**
 * Register Custom Post Type: Leads
 */
function hub_marketeria_register_lead_cpt() {
    $labels = array(
        'name'               => _x('Leads', 'post type general name', 'hub-marketeria'),
        'singular_name'      => _x('Lead', 'post type singular name', 'hub-marketeria'),
        'menu_name'          => _x('Leads', 'admin menu', 'hub-marketeria'),
        'add_new'            => _x('Add New', 'lead', 'hub-marketeria'),
        'add_new_item'       => __('Add New Lead', 'hub-marketeria'),
        'edit_item'          => __('Edit Lead', 'hub-marketeria'),
        'new_item'           => __('New Lead', 'hub-marketeria'),
        'view_item'          => __('View Lead', 'hub-marketeria'),
        'search_items'       => __('Search Leads', 'hub-marketeria'),
        'not_found'          => __('No leads found', 'hub-marketeria'),
        'not_found_in_trash' => __('No leads found in Trash', 'hub-marketeria'),
    );
    
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-groups',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );
    
    register_post_type('lead', $args);
}
add_action('init', 'hub_marketeria_register_lead_cpt');

/**
 * Register Lead Meta Fields
 */
function hub_marketeria_register_lead_meta() {
    // Email
    register_post_meta('lead', '_lead_email', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Company
    register_post_meta('lead', '_lead_company', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Search Term
    register_post_meta('lead', '_lead_search_term', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Chat History (JSON string)
    register_post_meta('lead', '_lead_chat_history', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Stage
    register_post_meta('lead', '_lead_stage', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 'Caixa de Entrada',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Score
    register_post_meta('lead', '_lead_score', array(
        'type'         => 'number',
        'single'       => true,
        'show_in_rest' => true,
        'default'      => 0,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
    
    // Score Reason
    register_post_meta('lead', '_lead_score_reason', array(
        'type'         => 'string',
        'single'       => true,
        'show_in_rest' => true,
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ));
}
add_action('init', 'hub_marketeria_register_lead_meta');

/**
 * Add Admin Menu for Funnel Dashboard
 */
function hub_marketeria_add_admin_menu() {
    add_menu_page(
        __('Funil de Vendas', 'hub-marketeria'),
        __('Funil de Vendas', 'hub-marketeria'),
        'edit_posts',
        'hub-marketeria-funnel',
        'hub_marketeria_render_funnel_page',
        'dashicons-chart-line',
        30
    );
}
add_action('admin_menu', 'hub_marketeria_add_admin_menu');

/**
 * Render Funnel Dashboard Admin Page
 */
function hub_marketeria_render_funnel_page() {
    require_once get_template_directory() . '/templates/admin-funnel.php';
}

/**
 * AJAX Handler: Generate Strategy
 */
function hub_marketeria_ajax_generate_strategy() {
    check_ajax_referer('hub_marketeria_nonce', 'nonce');
    
    $workflow_id = isset($_POST['workflow_id']) ? intval($_POST['workflow_id']) : 0;
    $client_description = isset($_POST['client_description']) ? sanitize_textarea_field($_POST['client_description']) : '';
    
    if (!$workflow_id) {
        wp_send_json_error(array('message' => 'Invalid workflow ID'));
    }
    
    $workflow = get_post($workflow_id);
    if (!$workflow || $workflow->post_type !== 'workflow') {
        wp_send_json_error(array('message' => 'Workflow not found'));
    }
    
    // Get workflow category
    $categories = get_the_terms($workflow_id, 'workflow_category');
    $category = $categories && !is_wp_error($categories) ? $categories[0]->name : 'General';
    
    // Get workflow emoji from custom field or use default
    $emoji = get_post_meta($workflow_id, '_workflow_emoji', true) ?: '🔄';
    
    // Generate strategy using Gemini API
    $strategy = hub_marketeria_generate_business_strategy(
        $workflow->post_title,
        $category,
        $emoji,
        $client_description
    );
    
    if (is_wp_error($strategy)) {
        wp_send_json_error(array('message' => $strategy->get_error_message()));
    }
    
    wp_send_json_success(array('strategy' => $strategy));
}
add_action('wp_ajax_generate_strategy', 'hub_marketeria_ajax_generate_strategy');
add_action('wp_ajax_nopriv_generate_strategy', 'hub_marketeria_ajax_generate_strategy');

/**
 * Generate Business Strategy via Gemini API
 */
function hub_marketeria_generate_business_strategy($workflow_title, $category, $emoji, $client_description) {
    $api_key = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : getenv('GEMINI_API_KEY');
    
    if (!$api_key) {
        return new WP_Error('no_api_key', 'Gemini API key not configured');
    }
    
    $client_desc = $client_description ?: 'A general small to medium-sized business';
    
    $prompt = "As an expert n8n automation consultant and business strategist, analyze the following workflow and generate a proposal for a potential client.

**Workflow Details:**
- **Name:** {$workflow_title}
- **Category:** {$category}

**Potential Client:**
- **Description:** {$client_desc}

**Your Task:**
Generate a comprehensive analysis and proposal. Structure your response in Markdown with the following sections:

### 🚀 Workflow Explanation
Briefly explain what this workflow does in simple, clear terms.

### 📈 Key Business Benefits
List 3-5 key benefits this workflow would provide for the specified client. Be specific and results-oriented (e.g., \"Increase lead conversion by X%\", \"Save Y hours per week\").

### 💰 Monetization Strategies
Suggest 2-3 ways I can sell this workflow as a service or product. For example:
1.  **One-Time Setup Fee:** A flat rate to implement the workflow.
2.  **Monthly Retainer:** For ongoing management, support, and optimization.
3.  **Productized Service:** Sell the pre-built workflow as a package.

### 🛠️ High-Level Implementation Steps
Provide a concise, step-by-step plan to implement this for the client.

### 💬 Sample Pitch
Write a short, compelling email or message to pitch this automation service to the client.

**Instructions:**
- Use clear headings and bullet points.
- Be professional, concise, and action-oriented.";
    
    $response = wp_remote_post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $api_key, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode(array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt)
                    )
                )
            )
        )),
        'timeout' => 30
    ));
    
    if (is_wp_error($response)) {
        return $response;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
        return $body['candidates'][0]['content']['parts'][0]['text'];
    }
    
    return new WP_Error('api_error', 'Failed to generate strategy');
}

/**
 * Register REST API Endpoint for Lead Capture
 */
function hub_marketeria_register_rest_routes() {
    register_rest_route('hub-marketeria/v1', '/lead', array(
        'methods' => 'POST',
        'callback' => 'hub_marketeria_create_lead',
        'permission_callback' => '__return_true', // Public endpoint for chatbot
    ));
}
add_action('rest_api_init', 'hub_marketeria_register_rest_routes');

/**
 * Create Lead via REST API
 */
function hub_marketeria_create_lead($request) {
    $params = $request->get_json_params();
    
    $name = isset($params['name']) ? sanitize_text_field($params['name']) : '';
    $email = isset($params['email']) ? sanitize_email($params['email']) : '';
    $company = isset($params['company']) ? sanitize_text_field($params['company']) : '';
    $search_term = isset($params['searchTerm']) ? sanitize_text_field($params['searchTerm']) : 'Direct Traffic';
    $chat_history = isset($params['chatHistory']) ? $params['chatHistory'] : array();
    
    if (!$name || !$email) {
        return new WP_Error('missing_data', 'Name and email are required', array('status' => 400));
    }
    
    // Create lead post
    $lead_id = wp_insert_post(array(
        'post_title' => $name,
        'post_type' => 'lead',
        'post_status' => 'publish',
    ));
    
    if (is_wp_error($lead_id)) {
        return $lead_id;
    }
    
    // Save meta fields
    update_post_meta($lead_id, '_lead_email', $email);
    update_post_meta($lead_id, '_lead_company', $company);
    update_post_meta($lead_id, '_lead_search_term', $search_term);
    update_post_meta($lead_id, '_lead_chat_history', json_encode($chat_history));
    update_post_meta($lead_id, '_lead_stage', 'Caixa de Entrada');
    
    // Generate lead score
    hub_marketeria_generate_lead_score_for_post($lead_id);
    
    return rest_ensure_response(array(
        'success' => true,
        'lead_id' => $lead_id,
        'message' => 'Lead created successfully'
    ));
}

/**
 * Generate Lead Score using Gemini API
 */
function hub_marketeria_generate_lead_score_for_post($lead_id) {
    $api_key = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : getenv('GEMINI_API_KEY');
    
    if (!$api_key) {
        return;
    }
    
    $name = get_the_title($lead_id);
    $company = get_post_meta($lead_id, '_lead_company', true);
    $search_term = get_post_meta($lead_id, '_lead_search_term', true);
    $chat_history_json = get_post_meta($lead_id, '_lead_chat_history', true);
    $chat_history = json_decode($chat_history_json, true) ?: array();
    
    // Format chat history
    $chat_text = '';
    foreach ($chat_history as $message) {
        $sender = isset($message['isUser']) && $message['isUser'] ? 'Client' : 'Assistant';
        $text = isset($message['text']) ? $message['text'] : '';
        $chat_text .= "{$sender}: {$text}\n";
    }
    
    $prompt = "Analyze the following sales lead and generate a lead score from 0 to 100.

**Lead Information:**
- Name: {$name}
- Company: {$company}
- Search Term Used: \"{$search_term}\"
- Full Conversation Transcript:
{$chat_text}

**Scoring Criteria:**
1.  **Search Term Intent (Weight: 40%):** How closely does the search term match high-value services?
    - High Score Keywords: \"consultoria automação\", \"n8n specialist\", \"automatizar processos\", \"hubspot alternative\".
    - Medium Score Keywords: \"marketing digital\", \"crm para pmes\".
    - Low Score Keywords: \"curso de marketing\", \"ferramentas gratuitas\".
    - \"Direct Traffic / Unknown\" should be scored moderately, relying more on the chat.
2.  **Engagement & Urgency (Weight: 60%):** How engaged and ready-to-act was the prospect in the chat?
    - High Score Indicators: Acknowledged a clear pain point (e.g., \"é exatamente isso!\"), asked clarifying questions (\"Como isso funciona?\"), quickly agreed to a call.
    - Low Score Indicators: Hesitant responses (\"Não tenho certeza.\"), chose \"Não, obrigado(a)\", generic answers.

**Output Format:**
You must respond with a JSON object containing two keys: \"score\" (a number between 0 and 100) and \"reason\" (a short, one-sentence explanation for the score).";
    
    $response = wp_remote_post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $api_key, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode(array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $prompt)
                    )
                )
            ),
            'generationConfig' => array(
                'response_mime_type' => 'application/json'
            )
        )),
        'timeout' => 30
    ));
    
    if (is_wp_error($response)) {
        return;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
        $result = json_decode($body['candidates'][0]['content']['parts'][0]['text'], true);
        
        if (isset($result['score']) && isset($result['reason'])) {
            update_post_meta($lead_id, '_lead_score', intval($result['score']));
            update_post_meta($lead_id, '_lead_score_reason', sanitize_text_field($result['reason']));
        }
    }
}

/**
 * AJAX Handler: Update Lead Stage
 */
function hub_marketeria_ajax_update_lead_stage() {
    check_ajax_referer('hub_marketeria_nonce', 'nonce');
    
    $lead_id = isset($_POST['lead_id']) ? intval($_POST['lead_id']) : 0;
    $new_stage = isset($_POST['stage']) ? sanitize_text_field($_POST['stage']) : '';
    
    $valid_stages = array('Caixa de Entrada', 'Qualificação', 'Oportunidade', 'Cliente (Ganho)', 'Perdido');
    
    if (!$lead_id || !in_array($new_stage, $valid_stages)) {
        wp_send_json_error(array('message' => 'Invalid data'));
    }
    
    update_post_meta($lead_id, '_lead_stage', $new_stage);
    
    wp_send_json_success(array('message' => 'Stage updated'));
}
add_action('wp_ajax_update_lead_stage', 'hub_marketeria_ajax_update_lead_stage');

/**
 * AJAX Handler: Generate AI Assistant Response
 */
function hub_marketeria_ajax_generate_ai_response() {
    check_ajax_referer('hub_marketeria_nonce', 'nonce');
    
    $user_prompt = isset($_POST['prompt']) ? sanitize_textarea_field($_POST['prompt']) : '';
    $assistant_type = isset($_POST['assistant_type']) ? sanitize_text_field($_POST['assistant_type']) : 'general-assistant';
    $data_context = isset($_POST['data_context']) ? sanitize_textarea_field($_POST['data_context']) : '';
    
    if (!$user_prompt) {
        wp_send_json_error(array('message' => 'Prompt is required'));
    }
    
    $response = hub_marketeria_generate_ai_response($user_prompt, $assistant_type, $data_context);
    
    if (is_wp_error($response)) {
        wp_send_json_error(array('message' => $response->get_error_message()));
    }
    
    wp_send_json_success(array('response' => $response));
}
add_action('wp_ajax_generate_ai_response', 'hub_marketeria_ajax_generate_ai_response');
add_action('wp_ajax_nopriv_generate_ai_response', 'hub_marketeria_ajax_generate_ai_response');

/**
 * Generate AI Assistant Response
 */
function hub_marketeria_generate_ai_response($user_prompt, $assistant_type, $data_context = '') {
    $api_key = defined('GEMINI_API_KEY') ? GEMINI_API_KEY : getenv('GEMINI_API_KEY');
    
    if (!$api_key) {
        return new WP_Error('no_api_key', 'Gemini API key not configured');
    }
    
    $system_instructions = array(
        'crm-strategist' => "You are a world-class CRM and Business Automation strategist. Your core philosophy is based on the \"Narrative Ladder\" framework. You believe traditional, monolithic CRMs are obsolete because they create data silos and lock users into a closed ecosystem. Your mission is to advocate for a modern, open, and integrated approach.\n\n**Your Narrative Ladder:**\n- **The Shift:** The world now runs on dozens of specialized apps (Slack, Meta, Google Ads, etc.), not one single software. Customer data is scattered.\n- **The Challenge:** Monolithic CRMs try to replace these tools, creating a \"walled garden\" that is rigid, expensive, and poorly adopted. Data becomes a hostage.\n- **The Impact:** This leads to disconnected data, manual copy-pasting, missed opportunities, and a fragmented view of the customer.\n- **The Solution:** A \"Smart Hub\" built on open-source technology (like n8n) that *unifies* existing tools instead of replacing them. It creates a central nervous system for the business.\n- **The Difference:** This approach is flexible, cost-effective, and ensures the client **owns their data and processes forever.** No vendor lock-in.\n\nWhen a user asks for copy, a strategy, or an explanation, you must use this narrative. Frame your answers around the concepts of unification, open-source freedom, and owning your own data. Challenge the idea of a single, closed-off CRM. Always be strategic, insightful, and persuasive.",
        'sales-copywriter' => "You are a world-class direct response copywriter and sales strategist, trained in the principles of Challenger Sale, Sandler, and Eugene Schwartz. Your goal is to write compelling, persuasive copy that addresses deep customer pain points, challenges their assumptions, and guides them towards a solution. Always focus on benefits over features, use clear and concise language, and end with a strong call to action. When asked for ideas, provide specific, actionable examples.",
        'content-strategist' => "You are a creative and data-driven B2B content strategist. Your expertise is in creating content that builds authority, educates the target audience, and generates qualified leads for technology and consulting services. When a user asks for ideas, provide them with headline suggestions, key talking points for a blog post or video, and a promotional snippet for social media. Your tone should be knowledgeable, helpful, and professional.",
        'business-consultant' => "You are a seasoned business consultant specializing in operational efficiency and automation for small to medium-sized businesses. You think in terms of systems, processes, and ROI. When a user presents a problem, your task is to break it down, identify the root cause, and propose a solution that involves automation. Provide high-level implementation steps and potential metrics to track success.",
        'general-assistant' => "You are a helpful and versatile AI assistant. Your goal is to provide clear, accurate, and concise answers to the user's questions on a wide range of topics."
    );
    
    $system_instruction = isset($system_instructions[$assistant_type]) ? $system_instructions[$assistant_type] : $system_instructions['general-assistant'];
    
    $final_prompt = $data_context 
        ? "Based on the following data, please answer the user's question.\n---\nDATA:\n{$data_context}\n---\nUSER QUESTION: {$user_prompt}"
        : $user_prompt;
    
    $response = wp_remote_post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-exp:generateContent?key=' . $api_key, array(
        'headers' => array('Content-Type' => 'application/json'),
        'body' => json_encode(array(
            'contents' => array(
                array(
                    'parts' => array(
                        array('text' => $final_prompt)
                    )
                )
            ),
            'systemInstruction' => array(
                'parts' => array(
                    array('text' => $system_instruction)
                )
            )
        )),
        'timeout' => 30
    ));
    
    if (is_wp_error($response)) {
        return $response;
    }
    
    $body = json_decode(wp_remote_retrieve_body($response), true);
    
    if (isset($body['candidates'][0]['content']['parts'][0]['text'])) {
        return $body['candidates'][0]['content']['parts'][0]['text'];
    }
    
    return new WP_Error('api_error', 'Failed to generate response');
}
