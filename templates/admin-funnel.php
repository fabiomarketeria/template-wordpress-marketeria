<?php
/**
 * Admin Funnel Dashboard Template
 *
 * @package Hub_Marketeria
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<div class="wrap hub-marketeria-admin">
    <h1>🎯 Funil de Vendas - Dashboard Kanban</h1>
    <p style="color: var(--color-gray-300); margin-bottom: 30px;">
        Gerencie seus leads arrastando e soltando entre os estágios. O score é calculado automaticamente pela IA.
    </p>

    <div id="kanban-loading" style="text-align: center; padding: 40px;">
        <div class="spinner"></div>
        <p class="loading-text">Carregando leads...</p>
    </div>

    <div id="kanban-board" class="kanban-board" style="display: none;"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', async function() {
    const kanbanBoard = document.getElementById('kanban-board');
    const kanbanLoading = document.getElementById('kanban-loading');
    
    const stages = [
        'Caixa de Entrada',
        'Qualificação',
        'Oportunidade',
        'Cliente (Ganho)',
        'Perdido'
    ];

    try {
        // Fetch all leads
        const response = await fetch(hubMarketeria.restUrl + 'wp/v2/lead?per_page=100&_embed', {
            headers: {
                'X-WP-Nonce': hubMarketeria.restNonce
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch leads');
        }

        const leads = await response.json();

        // Fetch meta data for each lead
        const leadsWithMeta = await Promise.all(leads.map(async lead => {
            const metaResponse = await fetch(hubMarketeria.restUrl + 'wp/v2/lead/' + lead.id, {
                headers: {
                    'X-WP-Nonce': hubMarketeria.restNonce
                }
            });
            const fullLead = await metaResponse.json();
            return {
                id: lead.id,
                name: lead.title.rendered,
                email: fullLead.meta._lead_email || '',
                company: fullLead.meta._lead_company || '',
                stage: fullLead.meta._lead_stage || 'Caixa de Entrada',
                score: parseInt(fullLead.meta._lead_score) || 0,
                scoreReason: fullLead.meta._lead_score_reason || ''
            };
        }));

        // Group leads by stage
        const leadsByStage = {};
        stages.forEach(stage => {
            leadsByStage[stage] = leadsWithMeta.filter(lead => lead.stage === stage);
        });

        // Render Kanban board
        kanbanBoard.innerHTML = '';
        stages.forEach(stage => {
            const column = createColumn(stage, leadsByStage[stage]);
            kanbanBoard.appendChild(column);
        });

        // Initialize Sortable for each column
        stages.forEach(stage => {
            const columnElement = document.querySelector(`[data-stage="${stage}"] .kanban-column-cards`);
            if (columnElement) {
                new Sortable(columnElement, {
                    group: 'shared',
                    animation: 150,
                    onEnd: function(evt) {
                        const leadId = evt.item.dataset.leadId;
                        const newStage = evt.to.closest('.kanban-column').dataset.stage;
                        updateLeadStage(leadId, newStage);
                    }
                });
            }
        });

        kanbanLoading.style.display = 'none';
        kanbanBoard.style.display = 'grid';

    } catch (error) {
        console.error('Error loading leads:', error);
        kanbanLoading.innerHTML = '<p style="color: var(--color-error);">Erro ao carregar leads.</p>';
    }

    function createColumn(stage, leads) {
        const column = document.createElement('div');
        column.className = 'kanban-column';
        column.dataset.stage = stage;

        const header = document.createElement('div');
        header.className = 'kanban-column-header';
        header.innerHTML = `
            <span>${stage}</span>
            <span class="kanban-column-count">${leads.length}</span>
        `;

        const cardsContainer = document.createElement('div');
        cardsContainer.className = 'kanban-column-cards';

        leads.forEach(lead => {
            const card = createLeadCard(lead);
            cardsContainer.appendChild(card);
        });

        column.appendChild(header);
        column.appendChild(cardsContainer);

        return column;
    }

    function createLeadCard(lead) {
        const card = document.createElement('div');
        card.className = 'lead-card';
        card.dataset.leadId = lead.id;

        let scoreClass = 'low';
        if (lead.score >= 70) scoreClass = 'high';
        else if (lead.score >= 40) scoreClass = 'medium';

        card.innerHTML = `
            <div class="lead-card-header">
                <div class="lead-card-name">${escapeHtml(lead.name)}</div>
                <div class="lead-score ${scoreClass}">${lead.score}</div>
            </div>
            <div class="lead-card-company">${escapeHtml(lead.company)}</div>
            <div class="lead-card-email">${escapeHtml(lead.email)}</div>
            ${lead.scoreReason ? `<p style="font-size: 12px; color: var(--color-gray-400); margin-top: 8px;">${escapeHtml(lead.scoreReason)}</p>` : ''}
        `;

        return card;
    }

    async function updateLeadStage(leadId, newStage) {
        try {
            const formData = new FormData();
            formData.append('action', 'update_lead_stage');
            formData.append('nonce', hubMarketeria.nonce);
            formData.append('lead_id', leadId);
            formData.append('stage', newStage);

            const response = await fetch(hubMarketeria.ajaxUrl, {
                method: 'POST',
                body: formData
            });

            const data = await response.json();

            if (!data.success) {
                console.error('Failed to update lead stage:', data);
                alert('Erro ao atualizar estágio do lead.');
            }
        } catch (error) {
            console.error('Error updating lead stage:', error);
            alert('Erro ao conectar com o servidor.');
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
});
</script>

<style>
/* Additional admin-specific styles */
.hub-marketeria-admin .kanban-column-cards {
    min-height: 100px;
}

.sortable-ghost {
    opacity: 0.4;
}

.sortable-drag {
    opacity: 0.8;
}
</style>
