# Hub Marketeria Theme - Project Structure

Complete file structure and organization of the WordPress theme.

## 📁 Directory Tree

```
hub-marketeria/
├── 📄 style.css (11K)              # Main theme stylesheet with dark theme
├── 📄 functions.php (26K)          # Core theme functions and features
├── 📄 index.php (754B)             # Main template file
├── 📄 header.php (273B)            # Header template
├── 📄 footer.php (39B)             # Footer template
├── 📄 single-workflow.php (6.0K)   # Single workflow template with AI generator
├── 📄 template-landing.php (3.3K)  # Landing page template
├── 📄 template-ai-library.php (5.8K) # AI Library page template
│
├── 📁 assets/
│   └── 📁 js/
│       ├── 📄 main.js (317B)       # Frontend JavaScript
│       └── 📄 admin.js (225B)      # Admin JavaScript
│
├── 📁 templates/
│   └── 📄 admin-funnel.php (6.5K)  # Kanban dashboard admin page
│
├── 📁 sample-data/
│   ├── 📄 workflows.json (3.6K)    # 33 sample workflows
│   └── 📄 README.md (3.4K)         # Import instructions
│
├── 📁 Documentation/
│   ├── 📄 README.md (4.1K)         # Theme overview and quick start
│   ├── 📄 INSTALLATION.md (9.6K)   # Detailed installation guide
│   ├── 📄 FEATURES.md (12K)        # Complete feature documentation
│   ├── 📄 CHANGELOG.md (5.0K)      # Version history
│   └── 📄 PROJECT-STRUCTURE.md     # This file
│
├── 📄 wp-config-sample.php (4.3K)  # Sample configuration file
└── 📄 .gitignore (278B)            # Git ignore rules
```

## 📊 File Statistics

### Total Files: 18
- **PHP Files**: 9 (43.5K total)
- **JavaScript Files**: 2 (542B total)
- **CSS Files**: 1 (11K)
- **Documentation Files**: 5 (40.6K total)
- **Data Files**: 2 (7.0K)

### Lines of Code (Approximate)
- **PHP**: ~1,500 lines
- **CSS**: ~500 lines
- **JavaScript**: ~300 lines
- **Documentation**: ~1,200 lines

## 🎨 Core Theme Files

### style.css (11K)
**Purpose**: Main stylesheet with dark theme design

**Contents**:
- Theme header information
- CSS variables for dark theme
- Base styles (typography, layout)
- Component styles (buttons, cards, forms)
- Kanban board styles
- Landing page styles
- Responsive design (mobile, tablet)
- Utility classes

**Key Features**:
- Professional dark color scheme
- Consistent spacing system
- Hover effects and transitions
- Loading animations
- Responsive grid layouts

### functions.php (26K)
**Purpose**: Core theme functionality

**Contents**:
- Theme setup and configuration
- Script and style enqueuing
- Custom Post Type registration (Workflows, Leads)
- Custom taxonomy registration (Workflow Categories)
- Meta field registration (7 lead fields)
- Admin menu pages
- AJAX handlers (3 handlers)
- REST API endpoint (lead capture)
- Gemini API integration functions
- Security functions (sanitization, validation)

**Functions Defined**:
1. `hub_marketeria_setup()` - Theme setup
2. `hub_marketeria_enqueue_scripts()` - Asset loading
3. `hub_marketeria_enqueue_admin_scripts()` - Admin assets
4. `hub_marketeria_register_workflow_cpt()` - Workflow CPT
5. `hub_marketeria_register_workflow_taxonomy()` - Workflow categories
6. `hub_marketeria_register_lead_cpt()` - Lead CPT
7. `hub_marketeria_register_lead_meta()` - Lead meta fields
8. `hub_marketeria_add_admin_menu()` - Admin menu
9. `hub_marketeria_render_funnel_page()` - Funnel dashboard
10. `hub_marketeria_ajax_generate_strategy()` - Strategy AJAX
11. `hub_marketeria_generate_business_strategy()` - Gemini strategy API
12. `hub_marketeria_register_rest_routes()` - REST API setup
13. `hub_marketeria_create_lead()` - Lead creation endpoint
14. `hub_marketeria_generate_lead_score_for_post()` - Lead scoring
15. `hub_marketeria_ajax_update_lead_stage()` - Stage update AJAX
16. `hub_marketeria_ajax_generate_ai_response()` - AI Library AJAX
17. `hub_marketeria_generate_ai_response()` - Gemini AI Library API

## 📄 Template Files

### index.php (754B)
**Type**: Main template
**Uses**: Loop, post display
**Features**: Archive listing, card layout

### header.php (273B)
**Type**: Header partial
**Uses**: HTML head, wp_head()
**Features**: Responsive viewport, charset

### footer.php (39B)
**Type**: Footer partial
**Uses**: wp_footer()
**Features**: Close body and html tags

### single-workflow.php (6.0K)
**Type**: Custom post type template
**Uses**: Workflow display, AI strategy generator
**Features**:
- Workflow header with emoji
- Category display
- Content area
- Strategy generator form
- AJAX form submission
- Markdown to HTML conversion
- Loading states
- Error handling

### template-landing.php (3.3K)
**Type**: Page template
**Uses**: Lead capture, chatbot integration
**Features**:
- Hero section
- Content area
- API documentation
- Endpoint display
- Payload examples
- cURL examples
- Chatbot integration guide

### template-ai-library.php (5.8K)
**Type**: Page template
**Uses**: AI content generation
**Features**:
- Persona selector (5 options)
- Prompt input
- Context input
- Response display
- AJAX submission
- Usage tips
- Loading states

### templates/admin-funnel.php (6.5K)
**Type**: Admin page template
**Uses**: Lead management, Kanban board
**Features**:
- 5-column Kanban layout
- Lead card rendering
- Drag-and-drop (SortableJS)
- Stage counters
- Score badges (color-coded)
- REST API integration
- Auto-update on drag
- Responsive grid

## 📜 JavaScript Files

### assets/js/main.js (317B)
**Purpose**: Frontend JavaScript
**Uses**: Theme initialization
**Features**: jQuery wrapper, console logging

### assets/js/admin.js (225B)
**Purpose**: Admin JavaScript
**Uses**: Admin page enhancement
**Features**: jQuery wrapper, console logging

**Note**: Most JavaScript is inline in templates for simplicity and context.

## 📚 Documentation Files

### README.md (4.1K)
**Purpose**: Theme overview
**Sections**:
- Quick start guide
- Feature list
- Installation link
- Configuration basics
- Lead stages
- AI personas
- File structure
- Requirements

### INSTALLATION.md (9.6K)
**Purpose**: Detailed setup guide
**Sections**:
- Prerequisites
- Installation methods (3 options)
- Gemini API configuration
- Sample data import
- Page creation
- Menu configuration
- Feature testing (4 tests)
- Chatbot integration (3 options)
- Troubleshooting (7 common issues)
- Next steps
- Security notes

### FEATURES.md (12K)
**Purpose**: Complete feature documentation
**Sections**:
- Design & UI overview
- Custom Post Types details
- AI-powered features (3 major features)
- Sales funnel (Kanban) details
- REST API endpoint documentation
- Page templates breakdown
- AJAX handlers
- Security features
- Dependencies
- CSS architecture
- Performance considerations
- Testing recommendations
- Future enhancements
- Metrics & KPIs

### CHANGELOG.md (5.0K)
**Purpose**: Version history
**Sections**:
- Version 1.0.0 details
- Added features (complete list)
- Technical details
- Known limitations
- Future considerations

### PROJECT-STRUCTURE.md (This file)
**Purpose**: File organization guide
**Sections**:
- Directory tree
- File statistics
- File descriptions
- Code organization

## 📦 Sample Data

### sample-data/workflows.json (3.6K)
**Format**: JSON array
**Contents**: 33 sample workflows
**Fields per workflow**:
- title (string)
- category (string)
- emoji (string)

**Categories included**:
- Reporting (3 workflows)
- AI & Data (1 workflow)
- Finance (3 workflows)
- Lead Generation (1 workflow)
- Social Media (6 workflows)
- Content Creation (1 workflow)
- Marketing (3 workflows)
- AI & Customer Service (2 workflows)
- Legal & Admin (1 workflow)
- Data Scraping (2 workflows)
- Utilities (2 workflows)
- Analytics (1 workflow)
- Development (1 workflow)
- Sales (2 workflows)
- Productivity (1 workflow)
- Sales & AI (3 workflows)
- Customer Service (1 workflow)
- E-commerce (1 workflow)

### sample-data/README.md (3.4K)
**Purpose**: Import instructions
**Contents**:
- Import methods (2 options)
- PHP import script
- WP-CLI import script
- Sample lead creation cURL command
- Testing instructions

## ⚙️ Configuration Files

### wp-config-sample.php (4.3K)
**Purpose**: Configuration reference
**Sections**:
- Gemini API key configuration
- WordPress database settings (commented)
- Debugging settings
- Security settings (authentication keys)
- Performance optimization
- REST API customization
- Theme-specific settings (custom constants)

**Custom Constants Available**:
- `HUB_MARKETERIA_AUTO_SCORE` - Enable/disable auto scoring
- `HUB_MARKETERIA_HIGH_SCORE_THRESHOLD` - High score threshold
- `HUB_MARKETERIA_MEDIUM_SCORE_THRESHOLD` - Medium score threshold
- `HUB_MARKETERIA_GEMINI_MODEL` - Custom Gemini model
- `HUB_MARKETERIA_LOG_AI_REQUESTS` - AI request logging

### .gitignore (278B)
**Purpose**: Git ignore rules
**Excludes**:
- .DS_Store, Thumbs.db
- IDE files (.vscode, .idea)
- Temporary files
- node_modules
- Build artifacts
- hub-marketeria.zip (original React app)

## 🔌 External Dependencies

### CDN Libraries
1. **Alpine.js v3.x** (defer loaded)
   - URL: `https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js`
   - Purpose: Lightweight JavaScript framework
   - Size: ~15KB

2. **SortableJS v1.15.0**
   - URL: `https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js`
   - Purpose: Drag-and-drop functionality
   - Size: ~20KB

### WordPress Core
- jQuery (bundled)
- WordPress REST API
- WordPress AJAX system

### External APIs
- **Google Gemini API**
  - Model: gemini-2.0-flash-exp
  - Endpoint: `https://generativelanguage.googleapis.com/v1beta/models/`
  - Features used:
    - Text generation
    - System instructions
    - JSON response schema

## 🗄️ Database Schema

### Custom Post Types

#### wp_posts (workflow)
- ID (Primary Key)
- post_title (Workflow name)
- post_content (Workflow description)
- post_type = 'workflow'
- post_status = 'publish'

#### wp_postmeta (workflow meta)
- `_workflow_emoji` (string) - Emoji icon

#### wp_posts (lead)
- ID (Primary Key)
- post_title (Lead name)
- post_type = 'lead'
- post_status = 'publish'

#### wp_postmeta (lead meta)
- `_lead_email` (string) - Email address
- `_lead_company` (string) - Company name
- `_lead_search_term` (string) - Search term
- `_lead_chat_history` (JSON string) - Chat messages
- `_lead_stage` (string) - Pipeline stage
- `_lead_score` (integer) - AI score 0-100
- `_lead_score_reason` (string) - Score explanation

#### wp_term_taxonomy (workflow_category)
- term_id (Primary Key)
- taxonomy = 'workflow_category'

## 🎯 API Endpoints

### REST API
- **POST** `/wp-json/hub-marketeria/v1/lead`
  - Creates new lead
  - Public access
  - Auto-triggers scoring

### AJAX Endpoints
- **POST** `/wp-admin/admin-ajax.php?action=generate_strategy`
  - Generates workflow strategy
  - Requires nonce

- **POST** `/wp-admin/admin-ajax.php?action=update_lead_stage`
  - Updates lead stage
  - Requires nonce, authentication

- **POST** `/wp-admin/admin-ajax.php?action=generate_ai_response`
  - Generates AI Library response
  - Requires nonce

## 🔐 Security Measures

### Input Validation
- Email validation with `sanitize_email()`
- Text sanitization with `sanitize_text_field()`
- Textarea sanitization with `sanitize_textarea_field()`
- Integer validation with `intval()`

### Output Escaping
- HTML escaping with `esc_html()`
- URL escaping with `esc_url()`
- Attribute escaping with `esc_attr()`

### Authentication
- Nonce verification on all AJAX calls
- Permission checks with `current_user_can()`
- Public endpoint with rate limiting potential

### Data Protection
- No sensitive data in frontend
- API keys in server-side config
- Prepared statements (WordPress methods)
- JSON encoding for data transfer

## 📈 Performance Profile

### Asset Loading
- **CSS**: 11KB (minifiable to ~8KB)
- **JavaScript**: ~20KB from CDN + ~1KB theme scripts
- **Total Page Weight**: ~50-100KB (depending on content)

### Database Queries
- Optimized with WordPress query functions
- Post meta indexed automatically
- Pagination ready (100 per page default)

### Caching
- Static assets cacheable
- REST API responses cacheable
- No session-based logic
- WordPress object cache compatible

### API Calls
- Async lead scoring (non-blocking)
- 30-second timeout
- Error handling and fallbacks
- Rate limit awareness

---

**Theme**: Hub Marketeria  
**Version**: 1.0.0  
**Total Size**: ~100KB (excluding dependencies)  
**Files**: 18  
**Last Updated**: 2025-11-14
