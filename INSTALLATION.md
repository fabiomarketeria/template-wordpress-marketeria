# Hub Marketeria Theme - Installation Guide

Complete step-by-step guide to install and configure the Hub Marketeria WordPress theme.

## Prerequisites

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB 10.2+)
- Gemini API key (free tier available at https://aistudio.google.com/app/apikey)

## Step 1: Install WordPress

If you don't have WordPress installed yet:

1. Download WordPress from https://wordpress.org/download/
2. Follow the WordPress installation guide
3. Complete the basic setup (database, admin user, etc.)

## Step 2: Install the Theme

### Option A: Upload via WordPress Admin

1. Download the theme as a ZIP file
2. Go to **Appearance** > **Themes** in WordPress admin
3. Click **Add New** > **Upload Theme**
4. Choose the ZIP file and click **Install Now**
5. Click **Activate** after installation

### Option B: Upload via FTP

1. Connect to your server via FTP
2. Upload the theme folder to `/wp-content/themes/`
3. Go to **Appearance** > **Themes** in WordPress admin
4. Find "Hub Marketeria" and click **Activate**

### Option C: Git Clone (for developers)

```bash
cd /path/to/wordpress/wp-content/themes/
git clone https://github.com/fabiomarketeria/template-wordpress-marketeria.git hub-marketeria
```

Then activate via WordPress admin.

## Step 3: Configure Gemini API Key

The theme requires a Gemini API key for AI features.

### Get Your API Key

1. Go to https://aistudio.google.com/app/apikey
2. Sign in with your Google account
3. Click "Create API Key"
4. Copy the generated key

### Add to WordPress Configuration

Edit your `wp-config.php` file and add:

```php
define('GEMINI_API_KEY', 'your-api-key-here');
```

Place this line before the "That's all, stop editing!" comment.

**Alternative:** Set as environment variable:

```bash
export GEMINI_API_KEY="your-api-key-here"
```

## Step 4: Import Sample Data

### Import Workflow Categories

1. Go to **Workflows** > **Categories**
2. Add the following categories manually:
   - Reporting
   - AI & Data
   - Finance
   - Lead Generation
   - Social Media
   - Content Creation
   - Marketing
   - AI & Customer Service
   - Legal & Admin
   - Data Scraping
   - Utilities
   - Analytics
   - Development
   - Sales
   - Productivity
   - Sales & AI
   - Customer Service
   - E-commerce

### Import Sample Workflows

Use the sample data provided in `/sample-data/workflows.json`.

**Method 1: Manual Import Script**

1. Add this code temporarily to your theme's `functions.php`:

```php
function hub_marketeria_import_workflows() {
    if (!isset($_GET['import_workflows']) || !current_user_can('manage_options')) {
        return;
    }
    
    $json = file_get_contents(get_template_directory() . '/sample-data/workflows.json');
    $workflows = json_decode($json, true);
    
    foreach ($workflows as $workflow) {
        $post_id = wp_insert_post(array(
            'post_title' => $workflow['title'],
            'post_type' => 'workflow',
            'post_status' => 'publish',
            'post_content' => 'Este é um workflow de automação para ' . $workflow['title']
        ));
        
        if (!is_wp_error($post_id)) {
            wp_set_object_terms($post_id, $workflow['category'], 'workflow_category');
            update_post_meta($post_id, '_workflow_emoji', $workflow['emoji']);
            echo "✓ Imported: " . $workflow['title'] . "<br>";
        }
    }
    
    echo "<br><strong>Import complete!</strong> You can now remove this code from functions.php";
    exit;
}
add_action('admin_init', 'hub_marketeria_import_workflows');
```

2. Visit: `https://your-site.com/wp-admin/?import_workflows=1`
3. Remove the code after import

**Method 2: WP-CLI** (if installed)

Create a file `import-workflows.php` in your theme root:

```php
<?php
$json = file_get_contents(get_template_directory() . '/sample-data/workflows.json');
$workflows = json_decode($json, true);

foreach ($workflows as $workflow) {
    $post_id = wp_insert_post(array(
        'post_title' => $workflow['title'],
        'post_type' => 'workflow',
        'post_status' => 'publish',
    ));
    
    if (!is_wp_error($post_id)) {
        wp_set_object_terms($post_id, $workflow['category'], 'workflow_category');
        update_post_meta($post_id, '_workflow_emoji', $workflow['emoji']);
        WP_CLI::success("Imported: " . $workflow['title']);
    }
}
```

Then run:

```bash
wp eval-file wp-content/themes/hub-marketeria/import-workflows.php
```

## Step 5: Create Pages

Create the following pages with their templates:

### Landing Page

1. Go to **Pages** > **Add New**
2. Title: "Landing Page" or "Captura de Leads"
3. In **Page Attributes**, select template: **Landing Page**
4. Add your content describing your services
5. Click **Publish**

### AI Library

1. Go to **Pages** > **Add New**
2. Title: "AI Library" or "Biblioteca de IA"
3. In **Page Attributes**, select template: **AI Library**
4. Click **Publish**

## Step 6: Configure Navigation Menu (Optional)

1. Go to **Appearance** > **Menus**
2. Create a new menu called "Primary Menu"
3. Add your pages:
   - Workflows (link to `/workflow/`)
   - Landing Page
   - AI Library
4. Assign to "Primary Menu" location
5. Save

## Step 7: Test AI Features

### Test Strategy Generator

1. Go to any Workflow page (e.g., "Fluxo de relatório de campanha Meta")
2. Scroll to "Gerador de Estratégia com IA"
3. Enter a client description, e.g.:
   ```
   Uma agência de marketing digital que gerencia campanhas para 20 clientes e precisa automatizar o envio de relatórios mensais.
   ```
4. Click "Gerar Proposta com IA"
5. Verify the AI generates a comprehensive strategy

### Test Lead Capture

Use cURL or Postman to test the lead capture endpoint:

```bash
curl -X POST https://your-site.com/wp-json/hub-marketeria/v1/lead \
  -H "Content-Type: application/json" \
  -d '{
    "name": "João Silva",
    "email": "joao@teste.com",
    "company": "Empresa Teste",
    "searchTerm": "consultoria automação",
    "chatHistory": [
      {"text": "Olá!", "isUser": false},
      {"text": "Preciso de ajuda com automação", "isUser": true}
    ]
  }'
```

Expected response:

```json
{
  "success": true,
  "lead_id": 123,
  "message": "Lead created successfully"
}
```

### Test Funnel Dashboard

1. Go to **Funil de Vendas** in the admin menu
2. You should see your test lead in the Kanban board
3. Try dragging the lead to a different column
4. The stage should update automatically

### Test AI Library

1. Go to the AI Library page you created
2. Select a persona (e.g., "CRM Strategist")
3. Enter a prompt, e.g.:
   ```
   Por que um Smart Hub é melhor que um CRM tradicional?
   ```
4. Click "Gerar Resposta"
5. Verify the AI responds in the style of the selected persona

## Step 8: Integrate Chatbot (Optional)

To capture leads automatically, integrate a chatbot:

### Option 1: Tidio

1. Sign up at https://www.tidio.com/
2. Install the Tidio WordPress plugin
3. Configure a chatbot flow to collect: Name, Email, Company
4. Use Tidio's webhook feature to send data to:
   ```
   POST https://your-site.com/wp-json/hub-marketeria/v1/lead
   ```

### Option 2: Typebot

1. Create account at https://typebot.io/
2. Build a chatbot flow collecting lead information
3. Add a webhook block at the end
4. Configure webhook to post to the lead capture endpoint

### Option 3: Custom Chatbot

Integrate your own chatbot by posting to the REST API endpoint. See `/sample-data/README.md` for examples.

## Troubleshooting

### "No API key configured" Error

**Problem:** AI features return "Gemini API key not configured"

**Solution:** 
- Check that `GEMINI_API_KEY` is defined in `wp-config.php`
- Verify the API key is valid at https://aistudio.google.com/
- Check for typos in the constant name

### Workflows Don't Appear

**Problem:** Can't see workflow post type

**Solution:**
- Go to **Settings** > **Permalinks**
- Click "Save Changes" (this flushes rewrite rules)
- Go back to **Workflows** menu

### Kanban Board Not Loading

**Problem:** Funnel dashboard shows loading spinner indefinitely

**Solution:**
- Open browser console (F12) and check for JavaScript errors
- Verify REST API is accessible: visit `https://your-site.com/wp-json/`
- Check if WordPress REST API is enabled
- Verify user has proper permissions

### Lead Scoring Doesn't Work

**Problem:** Leads created but score is 0

**Solution:**
- Verify Gemini API key is configured
- Check WordPress error log for API errors
- Try creating a lead with more detailed chat history
- Verify the search term is meaningful

### CORS Errors

**Problem:** Can't POST to REST API from external chatbot

**Solution:** Add to `functions.php`:

```php
add_action('rest_api_init', function() {
    remove_filter('rest_pre_serve_request', 'rest_send_cors_headers');
    add_filter('rest_pre_serve_request', function($value) {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Credentials: true');
        return $value;
    });
});
```

## Next Steps

1. **Customize Workflows:** Edit workflows to add detailed descriptions
2. **Add Content:** Create blog posts about automation
3. **Configure Email Notifications:** Set up alerts for new high-score leads
4. **Integrate CRM:** Connect with your existing CRM system
5. **Set Up Analytics:** Add Google Analytics to track conversions

## Support

For issues or questions:
- Check the README.md file
- Visit https://marketeria.com.br
- Review WordPress documentation at https://wordpress.org/support/

## Security Notes

- Keep WordPress and PHP updated
- Use strong passwords
- Limit wp-admin access
- Never commit your API key to version control
- Use HTTPS for your site
- Regularly backup your database
