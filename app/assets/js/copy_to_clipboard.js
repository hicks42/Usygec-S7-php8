/**
 * Copie le contenu d'un input dans le presse-papiers
 * @param {string} inputId - L'ID de l'élément input à copier
 */
window.copyToClipboard = function(inputId) {
    const input = document.getElementById(inputId);

    if (!input) {
        console.error('Element not found:', inputId);
        return;
    }

    // Sélectionner le texte
    input.select();
    input.setSelectionRange(0, 99999); // Pour mobile

    try {
        // Méthode moderne (Clipboard API)
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(input.value).then(() => {
                showCopySuccess(input);
            }).catch(err => {
                // Fallback sur l'ancienne méthode
                fallbackCopy(input);
            });
        } else {
            // Fallback pour les navigateurs plus anciens
            fallbackCopy(input);
        }
    } catch (err) {
        console.error('Erreur lors de la copie:', err);
    }
}

/**
 * Méthode de copie fallback pour les anciens navigateurs
 */
function fallbackCopy(input) {
    try {
        document.execCommand('copy');
        showCopySuccess(input);
    } catch (err) {
        console.error('Erreur lors de la copie (fallback):', err);
        alert('Erreur lors de la copie. Veuillez copier manuellement le lien.');
    }
}

/**
 * Affiche un feedback visuel de succès
 */
function showCopySuccess(input) {
    // Créer une notification temporaire
    const notification = document.createElement('div');
    notification.textContent = 'Lien copié !';
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-fade-in';
    notification.style.cssText = 'animation: fadeInOut 2s ease-in-out;';

    document.body.appendChild(notification);

    // Retirer la notification après 2 secondes
    setTimeout(() => {
        notification.remove();
    }, 2000);

    // Effet visuel sur le bouton
    const button = input.parentElement.querySelector('button[onclick*="copyToClipboard"]');
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = `
            <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Copié !
        `;
        button.classList.add('btn-success');
        button.classList.remove('btn-secondary');

        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            button.classList.add('btn-secondary');
        }, 2000);
    }
}

// Ajouter les styles d'animation
if (!document.getElementById('copy-clipboard-styles')) {
    const style = document.createElement('style');
    style.id = 'copy-clipboard-styles';
    style.textContent = `
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(-10px); }
            15% { opacity: 1; transform: translateY(0); }
            85% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(-10px); }
        }
    `;
    document.head.appendChild(style);
}
