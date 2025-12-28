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
 * Search
 */
function debounce(fn, delay = 200) {
    let timerId;
    return (...args) => {
        clearTimeout(timerId);
        timerId = setTimeout(() => fn(...args), delay);
    };
}

function search() {
    const searchInput = document.querySelector('[data-js-search]');
    if (!searchInput) return;

    const tbody = document.querySelector('table tbody');
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const cells = Array.from(tbody.querySelectorAll('td, th'));

    const escapeRegExp = (str) => str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    const escapeHtml = (str) => str.replace(/[&<>"']/g, (ch) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
    }[ch]));

    const highlightCellText = (query) => {
        if (!query) {
            cells.forEach(cell => {
                if (cell.dataset.originalText !== undefined) {
                    cell.textContent = cell.dataset.originalText;
                }
            });
            return;
        }

        const re = new RegExp(`(${escapeRegExp(query)})`, 'gi');
        cells.forEach(cell => {
            if (cell.dataset.originalText === undefined) {
                cell.dataset.originalText = cell.textContent;
            }
            const safeText = escapeHtml(cell.dataset.originalText);
            cell.innerHTML = safeText.replace(
                re,
                '<span class="bg-secondary text-white">$1</span>'
            );
        });
    };

    const applyFilter = () => {
        const query = searchInput.value.trim().toLowerCase();
        if (!query) {
            rows.forEach(row => row.classList.remove('hidden'));
            highlightCellText('');
            return;
        }

        rows.forEach(row => {
            const matches = row.textContent.toLowerCase().includes(query);
            row.classList.toggle('hidden', !matches);
        });
        highlightCellText(query);
    };

    const debouncedFilter = debounce(applyFilter, 200);
    searchInput.addEventListener('input', debouncedFilter);
}

// Run after DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    styleTables();
    styleMarks();
    search();
});
