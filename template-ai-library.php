<?php
/**
 * Template Name: AI Library
 * 
 * AI Library page template
 *
 * @package Hub_Marketeria
 */

get_header(); ?>

<div class="main-content">
    <div class="ai-library-container">
        <h1 class="text-center mb-4">📚 Biblioteca de IA</h1>
        <p class="text-center mb-4" style="color: var(--color-gray-300);">
            Use diferentes personas de IA para gerar conteúdo estratégico, copy de vendas, e muito mais.
        </p>

        <div class="card">
            <form id="ai-library-form">
                <div class="form-group ai-persona-selector">
                    <label for="assistant-type">Selecione a Persona da IA</label>
                    <select id="assistant-type" name="assistant_type">
                        <option value="general-assistant">Assistente Geral</option>
                        <option value="crm-strategist">CRM Strategist - Expert em Smart Hubs</option>
                        <option value="sales-copywriter">Sales Copywriter - Copy de Vendas</option>
                        <option value="content-strategist">Content Strategist - Estratégia de Conteúdo B2B</option>
                        <option value="business-consultant">Business Consultant - Consultoria de Automação</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="user-prompt">Seu Prompt</label>
                    <textarea 
                        id="user-prompt" 
                        name="user_prompt"
                        placeholder="Ex: Escreva um email de vendas para oferecer automação de relatórios..."
                        rows="6"
                        required
                    ></textarea>
                </div>

                <div class="form-group">
                    <label for="data-context">Contexto Adicional (Opcional)</label>
                    <textarea 
                        id="data-context" 
                        name="data_context"
                        placeholder="Cole dados relevantes, informações do cliente, ou contexto adicional..."
                        rows="4"
                    ></textarea>
                </div>

                <button type="submit" class="btn" id="generate-ai-btn">
                    Gerar Resposta
                </button>
            </form>

            <div id="ai-loading-indicator" class="hidden mt-4">
                <div class="spinner"></div>
                <p class="loading-text">Gerando resposta com IA...</p>
            </div>

            <div id="ai-response-output" class="ai-response-output hidden"></div>
        </div>

        <div class="card mt-4" style="background-color: var(--color-dark);">
            <h3>💡 Dicas de Uso</h3>
            <ul style="margin-left: 20px; color: var(--color-gray-300);">
                <li><strong>CRM Strategist:</strong> Use para explicar conceitos de "Smart Hub", criar argumentos contra CRMs tradicionais, e defender arquiteturas abertas.</li>
                <li><strong>Sales Copywriter:</strong> Ideal para emails de vendas, landing pages, e copy persuasivo seguindo metodologias como Challenger Sale.</li>
                <li><strong>Content Strategist:</strong> Gere ideias de conteúdo B2B, headlines, tópicos para blog posts e snippets para redes sociais.</li>
                <li><strong>Business Consultant:</strong> Analise problemas de negócio e proponha soluções com automação, incluindo ROI e métricas.</li>
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ai-library-form');
    const generateBtn = document.getElementById('generate-ai-btn');
    const loadingIndicator = document.getElementById('ai-loading-indicator');
    const responseOutput = document.getElementById('ai-response-output');
    const userPrompt = document.getElementById('user-prompt');
    const assistantType = document.getElementById('assistant-type');
    const dataContext = document.getElementById('data-context');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!userPrompt.value.trim()) {
            alert('Por favor, insira um prompt.');
            return;
        }

        // Show loading, hide output
        generateBtn.disabled = true;
        loadingIndicator.classList.remove('hidden');
        responseOutput.classList.add('hidden');
        responseOutput.textContent = '';

        try {
            const formData = new FormData();
            formData.append('action', 'generate_ai_response');
            formData.append('nonce', hubMarketeria.nonce);
            formData.append('prompt', userPrompt.value);
            formData.append('assistant_type', assistantType.value);
            formData.append('data_context', dataContext.value);

            const response = await fetch(hubMarketeria.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                responseOutput.textContent = data.data.response;
                responseOutput.classList.remove('hidden');
            } else {
                responseOutput.innerHTML = '<p style="color: var(--color-error);">Erro: ' + (data.data.message || 'Falha ao gerar resposta') + '</p>';
                responseOutput.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            responseOutput.innerHTML = '<p style="color: var(--color-error);">Erro ao conectar com o servidor.</p>';
            responseOutput.classList.remove('hidden');
        } finally {
            generateBtn.disabled = false;
            loadingIndicator.classList.add('hidden');
        }
    });
});
</script>

<?php get_footer(); ?>
