 function toggleDesc(el) {
    const card = el.closest('.feature-card'); // find the nearest card
    const desc = card.querySelector('.feature-desc'); // get only that card's desc
    const isCollapsed = desc.classList.contains('collapse');

    // First, collapse all other cards
    document.querySelectorAll('.feature-desc').forEach(d => {
      d.classList.add('collapse');
      const chevron = d.previousElementSibling;
      if (chevron && chevron.classList.contains('chevron')) {
        chevron.textContent = '⌄';
      }
    });

    // Then toggle the clicked one
    if (isCollapsed) {
      desc.classList.remove('collapse');
      el.textContent = '⌃';
    } else {
      desc.classList.add('collapse');
      el.textContent = '⌄';
    }
  }

// Add this script at the end of your body or in a DOM-ready handler
document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.querySelector('#accordionExample');
    const items = accordion.querySelectorAll('.accordion-item');

    // Open all items temporarily to calculate full height
    items.forEach(item => {
        const collapse = item.querySelector('.accordion-collapse');
        collapse.classList.add('show');
    });

    // Get the full height
    const fullHeight = accordion.offsetHeight;

    // Close all items (except any that should be open by default)
    items.forEach(item => {
        const collapse = item.querySelector('.accordion-collapse');
        if (!collapse.classList.contains('show')) {
            collapse.classList.remove('show');
        }
    });

    // Set the min-height
    accordion.style.minHeight = fullHeight + 'px';
});
