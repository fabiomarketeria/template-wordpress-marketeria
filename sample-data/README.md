# Sample Data for Hub Marketeria Theme

This directory contains sample data files to help you populate your WordPress installation with test content.

## workflows.json

Contains a list of 33 sample workflows based on the original Hub Marketeria application. Each workflow includes:
- **title**: The workflow name
- **category**: The workflow category
- **emoji**: An emoji icon for the workflow

### Importing Workflows

You can import these workflows manually or use a custom importer. Here's a simple PHP script to import them:

```php
<?php
// Add this to functions.php temporarily, then remove after import

function hub_marketeria_import_sample_workflows() {
    $json = file_get_contents(get_template_directory() . '/sample-data/workflows.json');
    $workflows = json_decode($json, true);
    
    foreach ($workflows as $workflow) {
        $post_id = wp_insert_post(array(
            'post_title' => $workflow['title'],
            'post_type' => 'workflow',
            'post_status' => 'publish',
            'post_content' => 'Sample workflow content. Edit this to add specific details about how this workflow works.'
        ));
        
        if (!is_wp_error($post_id)) {
            // Set category
            wp_set_object_terms($post_id, $workflow['category'], 'workflow_category');
            
            // Set emoji
            update_post_meta($post_id, '_workflow_emoji', $workflow['emoji']);
            
            echo "Imported: " . $workflow['title'] . " (ID: $post_id)<br>";
        }
    }
}

// Call this function once via admin URL: /wp-admin/?import_workflows=1
if (isset($_GET['import_workflows']) && current_user_can('manage_options')) {
    hub_marketeria_import_sample_workflows();
}
```

### Import via WP-CLI

If you have WP-CLI installed:

```bash
wp eval-file sample-data-importer.php
```

Create `sample-data-importer.php`:

```php
<?php
$json = file_get_contents(__DIR__ . '/sample-data/workflows.json');
$workflows = json_decode($json, true);

foreach ($workflows as $workflow) {
    $post_id = wp_insert_post(array(
        'post_title' => $workflow['title'],
        'post_type' => 'workflow',
        'post_status' => 'publish',
        'post_content' => 'This is an automation workflow for ' . $workflow['title']
    ));
    
    if (!is_wp_error($post_id)) {
        wp_set_object_terms($post_id, $workflow['category'], 'workflow_category');
        update_post_meta($post_id, '_workflow_emoji', $workflow['emoji']);
        WP_CLI::success("Imported: " . $workflow['title']);
    }
}
```

## Sample Lead Data

To test the lead capture system, you can use this sample cURL command:

```bash
curl -X POST https://your-site.com/wp-json/hub-marketeria/v1/lead \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Maria Silva",
    "email": "maria@empresa.com",
    "company": "Empresa de Marketing Digital",
    "searchTerm": "consultoria automação",
    "chatHistory": [
      {
        "text": "Olá! Como posso ajudar você hoje?",
        "isUser": false
      },
      {
        "text": "Estou procurando automatizar meus processos de marketing",
        "isUser": true
      },
      {
        "text": "Perfeito! Podemos ajudar com isso. Que tipo de processos você quer automatizar?",
        "isUser": false
      },
      {
        "text": "Principalmente relatórios de campanhas e captura de leads",
        "isUser": true
      }
    ]
  }'
```

This will create a lead with automatic AI scoring.
