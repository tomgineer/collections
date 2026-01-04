// Initialize styling for tables and mark elements when present.
export default function initStyling() {
    styleTables();
    styleMarks();
}

// Apply table-related utility classes site-wide.
function styleTables() {
    document.querySelectorAll('table').forEach(table => {
        table.classList.add('table', 'table-zebra');
    });
}

// Apply badge styling to all mark elements.
function styleMarks() {
    document.querySelectorAll('mark').forEach(mark => {
        mark.classList.add('badge', 'badge-dash', 'badge-accent' ,'badge-sm', 'ml-1');
    });
}
