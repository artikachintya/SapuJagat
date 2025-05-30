
function toggleDesc(button) {
    const card = button.closest('.feature-card');
    const desc = card.querySelector('.feature-desc');
    const chevron = card.querySelector('.chevron i');  // Changed this line
    const isCollapsed = desc.classList.contains('collapse');

    // Close all other descriptions first
    document.querySelectorAll('.feature-desc').forEach(d => {
        if (d !== desc) {
            d.classList.add('collapse');
            const otherCard = d.closest('.feature-card');
            otherCard.querySelector('.chevron i').classList.remove('fa-rotate-180');
        }
    });

    // Toggle current description
    if (isCollapsed) {
        desc.classList.remove('collapse');
        chevron.classList.add('fa-rotate-180');
    } else {
        desc.classList.add('collapse');
        chevron.classList.remove('fa-rotate-180');
    }
}


// Initialize the accordion
document.addEventListener('DOMContentLoaded', function () {
    const accordion = document.querySelector('#accordionExample');
    const items = accordion.querySelectorAll('.accordion-item');
    items.forEach(item => {
        const collapse = item.querySelector('.accordion-collapse');
        if (!collapse.classList.contains('show')) {
            collapse.classList.remove('show');
        }
    });

});
