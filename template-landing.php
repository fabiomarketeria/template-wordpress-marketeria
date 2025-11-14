<?php
/**
 * Template Name: Landing Page
 * 
 * Landing page template for lead capture
 *
 * @package Hub_Marketeria
 */

get_header(); ?>

<div class="landing-page">
    <div class="landing-hero">
        <h1>Automatize Seu Negócio com IA</h1>
        <p>Transforme processos manuais em fluxos inteligentes. Economize tempo, aumente resultados e escale seu negócio com automação profissional.</p>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="entry-content mt-4">
                <?php the_content(); ?>
            </div>
        <?php endwhile; endif; ?>
    </div>

    <div class="card" style="max-width: 600px;">
        <h2>🤖 Integração de Chatbot</h2>
        
        <div style="background-color: var(--color-dark); padding: 20px; border-radius: 8px; margin-top: 20px;">
            <h3>Como Integrar um Chatbot</h3>
            <p>Para capturar leads automaticamente, você pode integrar chatbots de terceiros:</p>
            
            <h4 style="margin-top: 20px;">Opções Recomendadas:</h4>
            <ul style="margin-left: 20px;">
                <li><strong>Tidio:</strong> Chatbot com formulários customizáveis</li>
                <li><strong>JivoChat:</strong> Chat ao vivo com captura de leads</li>
                <li><strong>Typebot:</strong> Construtor de chatbots visuais</li>
                <li><strong>Chatbot customizado:</strong> Use a API REST abaixo</li>
            </ul>

            <h4 style="margin-top: 20px;">Endpoint da API REST:</h4>
            <div style="background-color: var(--color-secondary); padding: 15px; border-radius: 6px; margin-top: 10px; font-family: monospace; overflow-x: auto;">
                <strong>POST</strong> <?php echo esc_url(rest_url('hub-marketeria/v1/lead')); ?>
            </div>

            <h4 style="margin-top: 20px;">Formato do Payload (JSON):</h4>
            <pre style="background-color: var(--color-secondary); padding: 15px; border-radius: 6px; margin-top: 10px; overflow-x: auto;"><code>{
  "name": "Nome do Lead",
  "email": "email@exemplo.com",
  "company": "Nome da Empresa",
  "searchTerm": "Como nos encontrou",
  "chatHistory": [
    {
      "text": "Olá!",
      "isUser": false
    },
    {
      "text": "Oi, preciso de ajuda",
      "isUser": true
    }
  ]
}</code></pre>

            <h4 style="margin-top: 20px;">Exemplo com cURL:</h4>
            <pre style="background-color: var(--color-secondary); padding: 15px; border-radius: 6px; margin-top: 10px; overflow-x: auto; font-size: 12px;"><code>curl -X POST <?php echo esc_url(rest_url('hub-marketeria/v1/lead')); ?> \
  -H "Content-Type: application/json" \
  -d '{
    "name": "João Silva",
    "email": "joao@empresa.com",
    "company": "Empresa XYZ",
    "searchTerm": "Google - consultoria automação",
    "chatHistory": [
      {"text": "Olá! Como posso ajudar?", "isUser": false},
      {"text": "Preciso automatizar meu marketing", "isUser": true}
    ]
  }'</code></pre>

            <p style="margin-top: 20px; color: var(--color-gray-300);">
                <strong>Nota:</strong> Quando um lead é criado, o sistema automaticamente calcula um score usando IA baseado no termo de busca e no histórico de conversa.
            </p>
        </div>
    </div>
</div>

<?php get_footer(); ?>
