# Hub Marketeria - WordPress Theme

Business-in-a-box platform for automation consultants. Dark theme with modern design for managing workflows, leads, and AI-powered business strategies.

## Features

- **Custom Post Types**
  - Workflows with categories
  - Leads with complete CRM functionality
  
- **AI-Powered Features**
  - Business strategy generator for workflows
  - Automatic lead scoring using Gemini AI
  - AI Library with multiple personas (CRM Strategist, Sales Copywriter, etc.)
  
- **Sales Funnel**
  - Kanban dashboard for lead management
  - Drag-and-drop interface
  - Automatic stage tracking
  
- **Lead Capture**
  - REST API endpoint for chatbot integration
  - Automatic lead scoring on creation
  - Support for chat history tracking

## Installation

1. Upload the theme to `/wp-content/themes/hub-marketeria/`
2. Activate the theme in WordPress admin
3. Configure the Gemini API key (see Configuration below)

## Configuration

### Gemini API Key

Add your Gemini API key to `wp-config.php`:

```php
define('GEMINI_API_KEY', 'your-api-key-here');
```

Or set it as an environment variable:

```bash
export GEMINI_API_KEY="your-api-key-here"
```

### Workflow Setup

1. Go to **Workflows** in the WordPress admin
2. Create workflows with:
   - Title
   - Category
   - Optional emoji (add as custom field `_workflow_emoji`)
   - Content/description

### Lead Capture API

The theme provides a REST API endpoint for lead capture:

**Endpoint:** `POST /wp-json/hub-marketeria/v1/lead`

**Payload:**
```json
{
  "name": "Lead Name",
  "email": "email@example.com",
  "company": "Company Name",
  "searchTerm": "How they found you",
  "chatHistory": [
    {
      "text": "Message text",
      "isUser": true/false
    }
  ]
}
```

### Pages Setup

Create the following pages with their respective templates:

1. **Landing Page** - Use template "Landing Page"
2. **AI Library** - Use template "AI Library"

### Chatbot Integration

Supported chatbots:
- Tidio
- JivoChat  
- Typebot
- Any custom chatbot that can send webhooks

Configure your chatbot to send POST requests to the lead capture endpoint with the required data format.

## Lead Stages

The funnel uses the following stages:

1. **Caixa de Entrada** - New leads
2. **Qualificação** - Qualification phase
3. **Oportunidade** - Opportunity identified
4. **Cliente (Ganho)** - Won deal
5. **Perdido** - Lost deal

## AI Personas

The AI Library includes the following personas:

- **General Assistant** - Versatile AI helper
- **CRM Strategist** - Expert in Smart Hubs and open-source CRM philosophy
- **Sales Copywriter** - Direct response copy following Challenger Sale methodology
- **Content Strategist** - B2B content strategy and lead generation
- **Business Consultant** - Operational efficiency and automation consulting

## Development

### File Structure

```
hub-marketeria/
├── assets/
│   └── js/
│       ├── main.js
│       └── admin.js
├── templates/
│   └── admin-funnel.php
├── functions.php
├── style.css
├── index.php
├── header.php
├── footer.php
├── single-workflow.php
├── template-landing.php
└── template-ai-library.php
```

### CSS Variables

The theme uses CSS variables for theming:

- `--color-dark`: Main dark background
- `--color-secondary`: Secondary background
- `--color-light`: Light text color
- `--color-accent`: Primary accent color
- `--color-accent-hover`: Hover state for accent
- `--color-gray-*`: Gray scale colors
- `--color-success`, `--color-warning`, `--color-error`: Status colors

## Requirements

- WordPress 5.0+
- PHP 7.4+
- Gemini API key

## License

GNU General Public License v2 or later

## Support

For support, please visit [https://marketeria.com.br](https://marketeria.com.br)
