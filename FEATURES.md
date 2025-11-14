# Hub Marketeria Theme - Features Overview

Complete feature breakdown of the WordPress theme implementation.

## 🎨 Design & User Interface

### Dark Theme
- Professional dark color scheme (`#030712` primary, `#111827` secondary)
- Custom CSS variables for easy theming
- Consistent color palette throughout
- Modern, clean interface inspired by the original React app

### Responsive Design
- Mobile-first approach
- Breakpoints at 768px for tablets and mobile
- Kanban board adapts to single column on mobile
- Forms and cards scale appropriately

### Components
- **Cards**: Elevated design with hover effects
- **Buttons**: Primary and secondary styles with hover states
- **Forms**: Clean input fields with focus states
- **Loading Spinners**: Animated loading indicators
- **Kanban Columns**: Draggable card interface

## 🔧 Custom Post Types

### Workflows CPT
- **Slug**: `workflow`
- **Features**: Title, Editor, Thumbnail
- **Taxonomy**: Workflow Categories
- **Custom Fields**: 
  - `_workflow_emoji` - Emoji icon for visual identification
- **REST API**: Enabled for external integrations
- **Archive Page**: Available at `/workflow/`

### Leads CPT
- **Slug**: `lead`
- **Features**: Title only (name of lead)
- **Custom Fields**:
  - `_lead_email` - Email address
  - `_lead_company` - Company name
  - `_lead_search_term` - How they found you
  - `_lead_chat_history` - JSON array of chat messages
  - `_lead_stage` - Pipeline stage (5 options)
  - `_lead_score` - AI-calculated score (0-100)
  - `_lead_score_reason` - AI explanation of score
- **REST API**: Enabled with custom endpoint
- **Admin Only**: Not publicly accessible

## 🤖 AI-Powered Features

### 1. Business Strategy Generator

**Location**: Single workflow pages (`single-workflow.php`)

**Functionality**:
- Input: Client description (optional)
- Process: Sends workflow details to Gemini API
- Output: Comprehensive business proposal in Markdown

**Sections Generated**:
- 🚀 Workflow Explanation
- 📈 Key Business Benefits
- 💰 Monetization Strategies
- 🛠️ High-Level Implementation Steps
- 💬 Sample Pitch

**Technical Details**:
- AJAX-powered (no page reload)
- Markdown to HTML conversion in JavaScript
- Timeout: 30 seconds
- Model: gemini-2.0-flash-exp

### 2. Automatic Lead Scoring

**Trigger**: When a new lead is created via REST API

**Process**:
1. Analyzes search term (40% weight)
2. Analyzes chat engagement (60% weight)
3. Generates score 0-100
4. Provides reasoning

**Scoring Logic**:
- **High Score (70+)**: Keywords like "consultoria automação", engaged chat
- **Medium Score (40-69)**: General marketing terms, moderate engagement
- **Low Score (0-39)**: Generic keywords, minimal engagement

**Technical Details**:
- Async processing (doesn't block lead creation)
- JSON response schema
- Stored in post meta
- Model: gemini-2.0-flash-exp

### 3. AI Library (5 Personas)

**Location**: AI Library page template

**Personas Available**:

1. **General Assistant**
   - Versatile AI helper
   - Wide range of topics

2. **CRM Strategist**
   - Focus: "Smart Hub" philosophy
   - Advocates for open-source, integrated systems
   - Challenges traditional CRMs
   - Uses "Narrative Ladder" framework

3. **Sales Copywriter**
   - Methodology: Challenger Sale, Sandler, Eugene Schwartz
   - Direct response copy
   - Pain point focused
   - Strong CTAs

4. **Content Strategist**
   - B2B content expertise
   - Lead generation focus
   - Headline suggestions
   - Social media snippets

5. **Business Consultant**
   - Operational efficiency
   - Automation solutions
   - ROI-focused
   - Process improvement

**Features**:
- Optional data context input
- Real-time response generation
- Pre-wrap text formatting
- Model: gemini-2.0-flash-exp with system instructions

## 📊 Sales Funnel (Kanban Dashboard)

**Location**: Admin menu "Funil de Vendas"

### Lead Stages
1. **Caixa de Entrada** - Inbox, new leads
2. **Qualificação** - Qualification phase
3. **Oportunidade** - Identified opportunity
4. **Cliente (Ganho)** - Won deal
5. **Perdido** - Lost deal

### Features
- **Drag & Drop**: Move leads between stages with SortableJS
- **Visual Scoring**: Color-coded score badges
  - Green (70+): High quality lead
  - Yellow (40-69): Medium quality
  - Gray (0-39): Low quality
- **Lead Cards Display**:
  - Lead name
  - Company
  - Email
  - Score with reasoning
- **Stage Counters**: Shows number of leads per column
- **Auto-Update**: AJAX saves stage changes
- **REST API Integration**: Fetches leads via WordPress REST API

### Technical Details
- Sortable.js v1.15.0 for drag-and-drop
- Real-time stage updates via AJAX
- No page reload required
- Per-column organization
- Responsive grid layout

## 🌐 REST API Endpoints

### Lead Capture Endpoint

**URL**: `POST /wp-json/hub-marketeria/v1/lead`

**Permission**: Public (no authentication required)

**Request Body** (JSON):
```json
{
  "name": "string (required)",
  "email": "string (required)",
  "company": "string (optional)",
  "searchTerm": "string (optional)",
  "chatHistory": [
    {
      "text": "string",
      "isUser": boolean
    }
  ]
}
```

**Response**:
```json
{
  "success": true,
  "lead_id": 123,
  "message": "Lead created successfully"
}
```

**Features**:
- Automatic lead scoring on creation
- Chat history preservation
- Search term tracking
- Email validation

## 📄 Page Templates

### 1. Landing Page (`template-landing.php`)

**Purpose**: Lead capture and chatbot integration

**Features**:
- Hero section with gradient heading
- Content area for service description
- API documentation display
- Chatbot integration guide
- cURL examples
- Webhook configuration instructions

**Supported Chatbots**:
- Tidio
- JivoChat
- Typebot
- Custom webhooks

### 2. AI Library (`template-ai-library.php`)

**Purpose**: AI-powered content generation

**Features**:
- Persona selector dropdown
- Prompt input (required)
- Context input (optional)
- Response display area
- Usage tips section
- AJAX-powered generation

### 3. Single Workflow (`single-workflow.php`)

**Purpose**: Display workflow details and generate strategies

**Features**:
- Workflow header with emoji
- Category display
- Content area
- Strategy generator form
- Real-time AI response
- Markdown rendering

## 🎯 AJAX Handlers

### 1. `generate_strategy`
- **Hook**: `wp_ajax_generate_strategy`, `wp_ajax_nopriv_generate_strategy`
- **Input**: workflow_id, client_description
- **Output**: AI-generated strategy (Markdown)
- **Security**: Nonce verification

### 2. `update_lead_stage`
- **Hook**: `wp_ajax_update_lead_stage`
- **Input**: lead_id, stage
- **Output**: Success/error message
- **Security**: Nonce verification, stage validation

### 3. `generate_ai_response`
- **Hook**: `wp_ajax_generate_ai_response`, `wp_ajax_nopriv_generate_ai_response`
- **Input**: prompt, assistant_type, data_context
- **Output**: AI-generated response
- **Security**: Nonce verification

## 🔒 Security Features

### Input Sanitization
- `sanitize_text_field()` for text inputs
- `sanitize_textarea_field()` for large text
- `sanitize_email()` for email addresses
- `intval()` for numeric values

### Nonce Verification
- All AJAX requests require valid nonce
- Nonces generated per-session
- Prevents CSRF attacks

### Permission Checks
- Admin functions check `current_user_can()`
- Lead meta requires `edit_posts` capability
- REST API endpoints have permission callbacks

### XSS Prevention
- `esc_html()` for output
- `esc_url()` for URLs
- `wp_kses_post()` for allowed HTML

### SQL Injection Prevention
- WordPress database methods (wpdb)
- Prepared statements
- No raw SQL queries

## 📦 Dependencies

### External Libraries (CDN)
- **Alpine.js v3.x**: Lightweight JavaScript framework
- **SortableJS v1.15.0**: Drag-and-drop functionality

### WordPress Core
- jQuery (included with WordPress)
- WordPress REST API
- WordPress AJAX system

### PHP Requirements
- PHP 7.4+
- WordPress 5.0+
- cURL extension (for API calls)
- JSON extension

### API Requirements
- Gemini API key (free tier available)
- Internet connection for API calls

## 🎨 CSS Architecture

### Variables
```css
--color-dark: #030712
--color-secondary: #111827
--color-light: #F9FAFB
--color-accent: #2563EB
--color-accent-hover: #1D4ED8
--color-gray-*: Gray scale
--color-success: #10B981
--color-warning: #F59E0B
--color-error: #EF4444
```

### Component Classes
- `.btn` - Button styles
- `.card` - Card container
- `.form-group` - Form field wrapper
- `.kanban-board` - Kanban grid
- `.lead-card` - Lead display card
- `.spinner` - Loading animation

### Utility Classes
- `.text-center` - Center text
- `.hidden` - Hide element
- `.mb-*`, `.mt-*` - Margins

## 📈 Performance Considerations

### Optimization Strategies
- CSS variables for theming (no inline styles)
- Minimal JavaScript (Alpine.js is only 15KB)
- AJAX for dynamic content (no page reloads)
- Efficient database queries
- Post meta for custom fields (indexed)

### Caching Compatibility
- No session usage
- REST API responses cacheable
- Static assets (CSS/JS) versionable

### Scalability
- REST API pagination support
- Efficient post queries
- Database-indexed meta queries
- Async AI processing

## 🧪 Testing Recommendations

### Unit Testing
- Test AJAX handlers with mock data
- Test API response parsing
- Test sanitization functions
- Test nonce verification

### Integration Testing
- Test full lead capture flow
- Test Kanban drag-and-drop
- Test AI generation workflows
- Test REST API endpoints

### User Acceptance Testing
- Create test workflows
- Generate test leads
- Move leads through funnel
- Test all AI personas
- Verify chatbot integration

### Security Testing
- Test XSS prevention
- Test SQL injection prevention
- Test CSRF protection
- Test permission boundaries
- CodeQL analysis (✅ Passed)

## 📚 Documentation

### User Documentation
- **README.md**: Overview and quick start
- **INSTALLATION.md**: Detailed setup guide
- **FEATURES.md**: This file, complete feature list

### Developer Documentation
- Inline code comments
- Function docblocks
- Template tags documentation
- Hook documentation

### Sample Data
- **workflows.json**: 33 sample workflows
- **sample-data/README.md**: Import instructions
- **wp-config-sample.php**: Configuration examples

## 🚀 Future Enhancement Ideas

### Potential Additions
1. **Email Notifications**: Notify on high-score leads
2. **Lead Assignment**: Assign leads to team members
3. **Activity Log**: Track all lead interactions
4. **Reports Dashboard**: Analytics and insights
5. **Export Functionality**: Export leads to CSV
6. **Integration Plugins**: Zapier, Make.com
7. **Advanced Filtering**: Filter leads by score, date, etc.
8. **Lead Notes**: Add internal notes to leads
9. **Automated Follow-ups**: Schedule automated emails
10. **Workflow Templates**: Pre-built workflow library

### Customization Options
- Custom AI prompts per workflow
- Configurable score thresholds
- Custom lead stages
- Theme color customization
- Custom email templates
- Additional AI personas

## 📊 Metrics & KPIs

### Trackable Metrics
- Number of leads captured
- Average lead score
- Conversion rate by stage
- Time in each stage
- AI generation usage
- Most popular workflows
- Lead source effectiveness

### Success Indicators
- High-score lead ratio
- Stage progression speed
- API endpoint uptime
- AI response quality
- User engagement with AI Library

---

**Theme Version**: 1.0.0  
**Last Updated**: 2025-11-14  
**WordPress Compatibility**: 5.0+  
**PHP Compatibility**: 7.4+
