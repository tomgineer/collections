// Wire up table search filtering and match highlighting.
export default function initSearch() {
    const searchInput = document.querySelector('[data-js-search]');
    if (!searchInput) return;

    const tbody = document.querySelector('table tbody');
    if (!tbody) return;

    const rows = Array.from(tbody.querySelectorAll('tr'));
    const cells = Array.from(tbody.querySelectorAll('td, th'));

    // Escape user input before building the highlight regex.
    const escapeRegExp = (str) => str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    // Escape cell text before injecting HTML highlights.
    const escapeHtml = (str) => str.replace(/[&<>"']/g, (ch) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
    }[ch]));

    // Highlight matching text across all table cells.
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

    // Filter visible rows based on the current search query.
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

    // Debounce input to avoid excessive DOM updates.
    const debouncedFilter = debounce(applyFilter, 200);
    searchInput.addEventListener('input', debouncedFilter);
}

// Debounce function execution to limit rapid calls.
function debounce(fn, delay = 200) {
    let timerId;
    return (...args) => {
        clearTimeout(timerId);
        timerId = setTimeout(() => fn(...args), delay);
    };
}
