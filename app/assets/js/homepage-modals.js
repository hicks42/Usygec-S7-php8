// Homepage Modals & Image Zoom JavaScript
import '../styles/pages/homepage.css';

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Show/hide scroll to top button
window.addEventListener('scroll', () => {
    const scrollTop = document.querySelector('.scroll-top');
    if (scrollTop) {
        if (window.pageYOffset > 300) {
            scrollTop.style.opacity = '1';
            scrollTop.style.visibility = 'visible';
        } else {
            scrollTop.style.opacity = '0';
            scrollTop.style.visibility = 'hidden';
        }
    }
});

// Modal functions
function openModal(modalId) {
    const modal = document.getElementById('modal-' + modalId);
    if (modal) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden'; // Empêcher le scroll du body
    }
}

function closeModal(modalId) {
    const modal = document.getElementById('modal-' + modalId);
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = ''; // Restaurer le scroll du body
    }
}

// Event delegation for project cards with data-modal attribute
document.addEventListener('DOMContentLoaded', () => {
    console.log('Homepage modals script loaded');

    // Log all cards with data-modal attribute
    const cards = document.querySelectorAll('[data-modal]');
    console.log('Found cards with data-modal:', cards.length);

    document.addEventListener('click', (e) => {
        console.log('Click detected on:', e.target);
        const card = e.target.closest('[data-modal]');
        if (card) {
            console.log('Card found with modal ID:', card.dataset.modal);
            const modalId = card.dataset.modal;
            openModal(modalId);
        }
    });
});

// Expose functions globally for backwards compatibility
window.openModal = openModal;
window.closeModal = closeModal;

// Fermer les modals avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('[id^="modal-"]');
        modals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                const modalId = modal.id.replace('modal-', '');
                if (modalId === 'image-zoom') {
                    closeImageZoom();
                } else {
                    closeModal(modalId);
                }
            }
        });
    }
});

// Image zoom functions
function openImageZoom(imageSrc, caption) {
    const modal = document.getElementById('modal-image-zoom');
    const zoomedImage = document.getElementById('zoomed-image');
    const imageCaption = document.getElementById('image-caption');

    if (modal && zoomedImage) {
        zoomedImage.src = imageSrc;
        zoomedImage.alt = caption;
        if (imageCaption) {
            imageCaption.textContent = caption;
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
}

function closeImageZoom() {
    const modal = document.getElementById('modal-image-zoom');
    if (modal) {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }
}

// Expose image zoom functions globally
window.openImageZoom = openImageZoom;
window.closeImageZoom = closeImageZoom;
