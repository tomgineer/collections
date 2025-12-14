/**
 * Adds DaisyUI table styling to all <table> elements.
 */
function styleTables() {
    document.querySelectorAll('table').forEach(table => {
        table.classList.add('table', 'table-zebra');
    });
}

/**
 * Adds DaisyUI badge styling to all <mark> elements.
 */
function styleMarks() {
    document.querySelectorAll('mark').forEach(mark => {
        mark.classList.add('badge', 'badge-dash', 'badge-accent' ,'badge-sm', 'ml-1');
    });
}

/**
 * Updates the text inside [data-js-count] to show
 * the number of rows inside the first <table><tbody>.
 */
function updateItemCount() {
    const tbody = document.querySelector('table tbody');
    const countEl = document.querySelector('[data-js-count]');

    if (!tbody || !countEl) return;

    const count = tbody.querySelectorAll('tr').length;
    countEl.textContent = `You own ${count} Items.`;
}

// Run after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    styleTables();
    styleMarks();
    updateItemCount();
});
