<?php
/**
 * Single Workflow Template
 *
 * @package Hub_Marketeria
 */

get_header(); ?>

<div class="main-content">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
            
            <div class="workflow-header">
                <div class="workflow-emoji">
                    <?php 
                    $emoji = get_post_meta(get_the_ID(), '_workflow_emoji', true);
                    echo $emoji ? esc_html($emoji) : '🔄';
                    ?>
                </div>
                <h1 class="workflow-title"><?php the_title(); ?></h1>
                <?php 
                $categories = get_the_terms(get_the_ID(), 'workflow_category');
                if ($categories && !is_wp_error($categories)) :
                    foreach ($categories as $category) : ?>
                        <span class="workflow-category"><?php echo esc_html($category->name); ?></span>
                    <?php endforeach;
                endif;
                ?>
            </div>

            <?php if (get_the_content()) : ?>
                <div class="card">
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="strategy-generator">
                <div class="card">
                    <h2>🚀 Gerador de Estratégia com IA</h2>
                    <p>Descreva seu cliente ou cenário para gerar uma proposta personalizada para este workflow.</p>
                    
                    <form id="strategy-form" class="mt-3">
                        <div class="form-group">
                            <label for="client-description">Descrição do Cliente</label>
                            <textarea 
                                id="client-description" 
                                name="client_description" 
                                placeholder="Ex: Uma agência de marketing digital de médio porte que precisa automatizar o envio de relatórios para clientes..."
                                rows="5"
                            ></textarea>
                        </div>
                        
                        <button type="submit" class="btn" id="generate-btn">
                            Gerar Proposta com IA
                        </button>
                    </form>

                    <div id="loading-indicator" class="hidden mt-4">
                        <div class="spinner"></div>
                        <p class="loading-text">Gerando estratégia com IA...</p>
                    </div>

                    <div id="strategy-output" class="strategy-output hidden"></div>
                </div>
            </div>

        <?php endwhile; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('strategy-form');
    const generateBtn = document.getElementById('generate-btn');
    const loadingIndicator = document.getElementById('loading-indicator');
    const strategyOutput = document.getElementById('strategy-output');
    const clientDescription = document.getElementById('client-description');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        // Show loading, hide output
        generateBtn.disabled = true;
        loadingIndicator.classList.remove('hidden');
        strategyOutput.classList.add('hidden');
        strategyOutput.innerHTML = '';

        try {
            const formData = new FormData();
            formData.append('action', 'generate_strategy');
            formData.append('nonce', hubMarketeria.nonce);
            formData.append('workflow_id', <?php echo get_the_ID(); ?>);
            formData.append('client_description', clientDescription.value);

            const response = await fetch(hubMarketeria.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                // Convert Markdown to HTML (basic conversion)
                const htmlContent = convertMarkdownToHTML(data.data.strategy);
                strategyOutput.innerHTML = htmlContent;
                strategyOutput.classList.remove('hidden');
            } else {
                strategyOutput.innerHTML = '<p style="color: var(--color-error);">Erro: ' + (data.data.message || 'Falha ao gerar estratégia') + '</p>';
                strategyOutput.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            strategyOutput.innerHTML = '<p style="color: var(--color-error);">Erro ao conectar com o servidor.</p>';
            strategyOutput.classList.remove('hidden');
        } finally {
            generateBtn.disabled = false;
            loadingIndicator.classList.add('hidden');
        }
    });

    // Basic Markdown to HTML converter
    function convertMarkdownToHTML(markdown) {
        let html = markdown;
        
        // Headers
        html = html.replace(/^### (.*$)/gim, '<h3>$1</h3>');
        html = html.replace(/^## (.*$)/gim, '<h2>$1</h2>');
        html = html.replace(/^# (.*$)/gim, '<h1>$1</h1>');
        
        // Bold
        html = html.replace(/\*\*(.*?)\*\*/gim, '<strong>$1</strong>');
        
        // Lists
        html = html.replace(/^\* (.*$)/gim, '<li>$1</li>');
        html = html.replace(/^\d+\. (.*$)/gim, '<li>$1</li>');
        
        // Wrap consecutive list items in ul
        html = html.replace(/(<li>.*<\/li>\n?)+/gim, '<ul>$&</ul>');
        
        // Paragraphs
        html = html.replace(/\n\n/g, '</p><p>');
        html = '<p>' + html + '</p>';
        
        // Clean up
        html = html.replace(/<p><h/g, '<h');
        html = html.replace(/<\/h([1-6])><\/p>/g, '</h$1>');
        html = html.replace(/<p><ul>/g, '<ul>');
        html = html.replace(/<\/ul><\/p>/g, '</ul>');
        html = html.replace(/<p><\/p>/g, '');
        
        return html;
    }
});
</script>

<?php get_footer(); ?>
