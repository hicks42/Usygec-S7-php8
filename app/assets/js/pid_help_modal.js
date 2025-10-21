/**
 * Gestion de la modal intelligente pour trouver et extraire le Google Place ID
 */

// Variable globale pour stocker le PID extrait
let extractedPlaceId = null;

// Variable pour stocker le champ Pid cible (celui qui a ouvert la modal)
let targetPidField = null;

// Variables pour stocker le nom et le code postal de l'établissement
let establishmentName = '';
let postalCode = '';

/**
 * Ouvrir la modal (version classique - pour les formulaires existants)
 * @param {HTMLElement} pidField - Le champ Pid du formulaire qui a déclenché l'ouverture
 */
window.openPidHelpModal = function(pidField) {
    const modal = document.getElementById('pidHelpModal');
    if (modal) {
        // Stocker la référence au champ Pid
        targetPidField = pidField;

        // Réinitialiser la modal
        resetModal();

        // Pré-remplir le nom de l'établissement depuis le formulaire
        prefillEstablishmentName(pidField);

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
};

/**
 * Ouvrir la modal (nouvelle version - pour les nouveaux formulaires)
 * @param {HTMLElement} button - Le bouton "Créer le lien" qui a déclenché l'ouverture
 */
window.openPidHelpModalNew = function(button) {
    const modal = document.getElementById('pidHelpModal');
    if (!modal) return;

    // Trouver le formulaire parent
    const formContainer = button.closest('[data-structure-form]');
    if (!formContainer) return;

    // Récupérer le champ Pid caché
    const pidField = formContainer.querySelector('input[data-pid-field]');
    if (!pidField) return;

    // Stocker la référence au champ Pid
    targetPidField = pidField;

    // Réinitialiser la modal
    resetModal();

    // Récupérer le nom et le code postal du formulaire
    const nameField = formContainer.querySelector('input[id*="_name"]');
    const cpField = formContainer.querySelector('input[id*="_cp"]');

    establishmentName = nameField && nameField.value.trim() ? nameField.value.trim() : '';
    postalCode = cpField && cpField.value.trim() ? cpField.value.trim() : '';

    // Validation
    if (!establishmentName) {
        alert('Veuillez d\'abord saisir le nom de l\'établissement');
        nameField.focus();
        return;
    }

    if (!postalCode) {
        alert('Veuillez d\'abord saisir le code postal');
        cpField.focus();
        return;
    }

    // Pré-remplir le popup avec le nom et le code postal
    const displayElement = document.getElementById('establishmentNameDisplay');
    if (displayElement) {
        displayElement.textContent = `${establishmentName} (${postalCode})`;
    }

    // Réinitialiser le champ type d'activité
    document.getElementById('pidActivityType').value = '';

    // Ouvrir la modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
};

/**
 * Pré-remplir le nom de l'établissement depuis le champ "name" du formulaire
 * @param {HTMLElement} pidField - Le champ Pid qui nous permet de retrouver le formulaire parent
 */
function prefillEstablishmentName(pidField) {
    // Trouver le formulaire parent (collection-item ou form)
    const formContainer = pidField.closest('.collection-item') || pidField.closest('form');

    if (formContainer) {
        // Chercher le champ "name" dans ce container
        // Le champ peut avoir un ID comme "user_structures_0_name" ou similaire
        const nameField = formContainer.querySelector('input[id*="_name"]');

        if (nameField && nameField.value.trim()) {
            // Pré-remplir le champ de recherche avec le nom
            const establishmentName = nameField.value.trim();
            document.getElementById('pidSearchName').value = establishmentName;

            // Afficher également le nom dans les instructions
            const displayElement = document.getElementById('establishmentNameDisplay');
            if (displayElement) {
                displayElement.textContent = establishmentName;
            }
        }
    }
}

/**
 * Fermer la modal
 */
window.closePidHelpModal = function() {
    const modal = document.getElementById('pidHelpModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        resetModal();
        targetPidField = null;
    }
};

/**
 * Ouvrir Google Maps avec la recherche (type d'activité + code postal)
 */
window.openGoogleMapsWithSearch = function() {
    const activityType = document.getElementById('pidActivityType').value.trim();

    if (!activityType) {
        alert('Veuillez saisir le type d\'activité (ex: Restaurant, Hôtel, Boulangerie...)');
        document.getElementById('pidActivityType').focus();
        return;
    }

    // Créer la recherche : "type d'activité + code postal"
    const searchQuery = `${activityType} ${postalCode}`;
    const encodedQuery = encodeURIComponent(searchQuery);
    const googleMapsUrl = `https://www.google.com/maps/search/${encodedQuery}`;

    // Ouvrir dans un nouvel onglet
    window.open(googleMapsUrl, '_blank');
};

/**
 * Réinitialiser la modal
 */
function resetModal() {
    // Réinitialiser les champs
    document.getElementById('pidUrlInput').value = '';
    document.getElementById('pidActivityType').value = '';

    // Cacher les résultats
    document.getElementById('pidExtractedResult').classList.add('hidden');
    document.getElementById('pidErrorResult').classList.add('hidden');

    // Désactiver le bouton de confirmation
    document.getElementById('pidConfirmBtn').disabled = true;

    // Réinitialiser le PID extrait
    extractedPlaceId = null;
}

/**
 * Extraire le Place ID depuis l'URL Google Maps collée
 * L'extraction se fait côté client en analysant l'URL
 */
window.extractPidFromUrl = function() {
    const url = document.getElementById('pidUrlInput').value.trim();

    if (!url) {
        showError('Veuillez coller un lien Google Maps');
        return;
    }

    // Chercher le Place ID dans l'URL
    // Format possible :
    // - https://www.google.com/maps/place/...data=...!1s0x...:0x...!8m2!3d...!4d...
    // - https://maps.app.goo.gl/...
    // Le PID commence toujours par "ChIJ" et peut être dans différents paramètres

    let placeId = null;

    // Méthode 1 : Rechercher dans les paramètres d'URL (ftid, ludocid, cid, etc.)
    const patterns = [
        /1s(ChIJ[a-zA-Z0-9_-]+)/,           // Format: !1sChIJ...
        /ftid=(ChIJ[a-zA-Z0-9_-]+)/,        // Format: ftid=ChIJ...
        /place_id=(ChIJ[a-zA-Z0-9_-]+)/,   // Format: place_id=ChIJ...
        /ChIJ[a-zA-Z0-9_-]+/                // Format: directement ChIJ...
    ];

    for (const pattern of patterns) {
        const match = url.match(pattern);
        if (match) {
            placeId = match[1] || match[0];
            // Vérifier que ça commence bien par ChIJ
            if (placeId.startsWith('ChIJ')) {
                break;
            }
        }
    }

    if (placeId) {
        extractedPlaceId = placeId;
        showSuccess(extractedPlaceId);
    } else {
        showError('Aucun Place ID trouvé dans ce lien. Vérifiez que vous avez bien copié le lien depuis le nom de l\'établissement sur Google Maps.');
    }
};

/**
 * Afficher le succès avec le PID trouvé
 */
function showSuccess(placeId) {
    // Afficher le résultat
    document.getElementById('pidExtractedValue').textContent = placeId;
    document.getElementById('pidExtractedResult').classList.remove('hidden');
    document.getElementById('pidErrorResult').classList.add('hidden');

    // Activer le bouton de confirmation
    document.getElementById('pidConfirmBtn').disabled = false;

    // Fermeture automatique après 1 seconde pour laisser voir le succès
    setTimeout(() => {
        confirmAndFillPid();
    }, 1000);
}

/**
 * Afficher l'erreur
 */
function showError(message = 'Aucun Place ID trouvé dans ce lien. Vérifiez que vous avez bien copié le lien depuis le nom de l\'établissement sur Google Maps.') {
    document.getElementById('pidExtractedResult').classList.add('hidden');
    const errorElement = document.getElementById('pidErrorResult');
    errorElement.classList.remove('hidden');
    errorElement.querySelector('p').textContent = '✗ ' + message;
    document.getElementById('pidConfirmBtn').disabled = true;
    extractedPlaceId = null;
}

/**
 * Confirmer et remplir le champ Pid dans le formulaire principal
 */
window.confirmAndFillPid = function() {
    if (!extractedPlaceId) {
        return;
    }

    // Trouver le champ Pid dans le formulaire
    // Il peut y avoir plusieurs structures, on remplit celle qui est ciblée
    if (targetPidField) {
        targetPidField.value = extractedPlaceId;

        // Déclencher un événement pour que Symfony détecte le changement
        targetPidField.dispatchEvent(new Event('input', { bubbles: true }));
        targetPidField.dispatchEvent(new Event('change', { bubbles: true }));

        // Notification visuelle
        targetPidField.classList.add('border-green-500', 'bg-green-50');
        setTimeout(() => {
            targetPidField.classList.remove('border-green-500', 'bg-green-50');
        }, 2000);

        // Si c'est un nouveau formulaire, afficher le reste du formulaire
        const formContainer = targetPidField.closest('[data-structure-form]');
        if (formContainer) {
            const restOfForm = formContainer.querySelector('[data-rest-form]');
            if (restOfForm) {
                restOfForm.classList.remove('hidden');

                // Scroll vers le reste du formulaire
                setTimeout(() => {
                    restOfForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, 300);
            }
        }
    }

    // Fermer la modal
    closePidHelpModal();
};

/**
 * Initialisation au chargement de la page
 */
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('pidHelpModal');

    if (modal) {
        // Fermer avec le fond noir
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closePidHelpModal();
            }
        });
    }

    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePidHelpModal();
        }
    });

    // Extraction automatique lors du collage dans le champ URL
    const urlInput = document.getElementById('pidUrlInput');
    if (urlInput) {
        // Extraire automatiquement lors du collage
        urlInput.addEventListener('paste', function() {
            // Attendre que la valeur soit collée
            setTimeout(() => {
                extractPidFromUrl();
            }, 100);
        });

        // Extraire également lors de la saisie manuelle
        urlInput.addEventListener('input', function() {
            const url = urlInput.value.trim();
            if (url.length > 20) { // Éviter de déclencher trop tôt
                // Cacher les messages précédents si le champ change
                document.getElementById('pidExtractedResult').classList.add('hidden');
                document.getElementById('pidErrorResult').classList.add('hidden');
            }
        });

        // Extraire au blur (quand l'utilisateur quitte le champ)
        urlInput.addEventListener('blur', function() {
            const url = urlInput.value.trim();
            if (url && !extractedPlaceId) {
                extractPidFromUrl();
            }
        });
    }
});
