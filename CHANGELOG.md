# Changelog

All notable changes to the Hub Marketeria WordPress theme will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-11-14

### Added

#### Core Theme
- Initial theme setup with WordPress standards
- Dark theme styling with CSS variables
- Responsive design for mobile, tablet, and desktop
- Professional UI components (buttons, cards, forms, loading states)
- Header and footer templates
- Index template for archives

#### Custom Post Types
- **Workflows CPT** with custom taxonomy for categories
- **Leads CPT** with comprehensive meta fields
- REST API support for both post types
- Custom emoji field for workflows (`_workflow_emoji`)

#### Lead Management
- Lead meta fields: email, company, search term, chat history, stage, score, score reason
- Five lead stages: Caixa de Entrada, Qualificação, Oportunidade, Cliente (Ganho), Perdido
- Kanban dashboard in WordPress admin with drag-and-drop functionality
- Visual score indicators (color-coded: high/medium/low)
- Real-time stage updates via AJAX

#### AI Features
- **Business Strategy Generator** on workflow pages
  - Client description input
  - Comprehensive proposal generation
  - Markdown to HTML rendering
  - Sections: Explanation, Benefits, Monetization, Implementation, Pitch

- **Automatic Lead Scoring**
  - AI-powered scoring on lead creation
  - Analyzes search terms and chat engagement
  - Score range: 0-100
  - Includes reasoning explanation

- **AI Library** with 5 personas:
  - General Assistant
  - CRM Strategist (Smart Hub philosophy)
  - Sales Copywriter (Challenger Sale methodology)
  - Content Strategist (B2B focus)
  - Business Consultant (Automation expert)

#### REST API
- Custom endpoint: `POST /wp-json/hub-marketeria/v1/lead`
- Public access for chatbot integration
- Automatic lead scoring on creation
- JSON request/response format
- Email validation and sanitization

#### Page Templates
- **Landing Page Template** with chatbot integration guide
- **AI Library Template** with persona selector
- **Single Workflow Template** with strategy generator
- All templates fully styled and responsive

#### AJAX Handlers
- `generate_strategy` - Generate business strategies
- `update_lead_stage` - Update lead pipeline stage
- `generate_ai_response` - AI Library responses
- All handlers with nonce verification and input sanitization

#### Security
- Comprehensive input sanitization
- CSRF protection with nonces
- XSS prevention with output escaping
- Permission checks for admin functions
- SQL injection prevention with WordPress methods
- CodeQL security analysis passed

#### Documentation
- README.md with quick start guide
- INSTALLATION.md with detailed setup instructions
- FEATURES.md with complete feature breakdown
- CHANGELOG.md (this file)
- Sample data directory with 33 workflows
- wp-config-sample.php with configuration examples
- Inline code comments and docblocks

#### Dependencies
- Alpine.js v3.x for lightweight interactivity
- SortableJS v1.15.0 for drag-and-drop
- Gemini API integration (gemini-2.0-flash-exp)

#### Sample Data
- 33 sample workflows in JSON format
- Multiple categories: Reporting, AI & Data, Finance, Marketing, etc.
- Import scripts and instructions
- Sample cURL commands for testing

#### Developer Tools
- .gitignore for WordPress development
- Clean directory structure
- Modular template files
- Reusable JavaScript functions
- PHP syntax validation

### Technical Details

#### API Integration
- Gemini API for all AI features
- 30-second timeout for API calls
- Error handling and fallbacks
- JSON response parsing
- System instruction support for personas

#### Database
- Post meta for lead data
- Efficient queries with WordPress functions
- Indexed meta keys for performance
- JSON storage for chat history

#### Frontend
- No build process required
- CDN-hosted libraries
- Vanilla JavaScript for form handling
- Basic Markdown parser
- AJAX without jQuery

#### Compatibility
- WordPress 5.0+
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.2+
- Modern browsers (Chrome, Firefox, Safari, Edge)

### Known Limitations

- Gemini API key required for AI features
- Internet connection required for AI operations
- API rate limits apply (depends on Gemini plan)
- No built-in email notifications (can be added)
- No team member assignment (single user focus)

### Future Considerations

- Email notifications for high-score leads
- Team member assignment system
- Activity logging
- Advanced reporting dashboard
- Export to CSV functionality
- Integration with Zapier/Make.com
- Custom workflow templates
- Lead notes and comments
- Automated follow-up sequences

---

## Version History

- **1.0.0** (2025-11-14) - Initial release with complete feature set

---

For upgrade instructions and migration guides, see [INSTALLATION.md](INSTALLATION.md).

For detailed feature documentation, see [FEATURES.md](FEATURES.md).
