<?php
// app/php/engine.php

declare(strict_types=1);

/**
 * Scan /html folder and return an array of navigation items.
 * Uses the processed HTML version (html/processed) for each file.
 *
 * Example:
 * [
 *   'movies' => ['path' => '/.../html/processed/movies.html', 'title' => 'Movies'],
 *   'games'  => ['path' => '/.../html/processed/games.html',  'title' => 'Games']
 * ]
 */
function getNavigationItems(): array {
    $dir   = __DIR__ . '/../../html';
    $files = glob($dir . '/*.html');

    $pages = [];

    if ($files !== false) {
        sort($files, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($files as $file) {
            $slug  = basename($file, '.html');
            $title = ucwords(str_replace(['-', '_'], ' ', $slug));

            // Try to get (or generate) the processed version
            $processedPath = getProcessedFilePath($file);

            $pages[$slug] = [
                // Prefer processed file; fall back to raw if something went wrong
                'path'  => $processedPath ?? $file,
                'title' => $title,
            ];
        }
    }

    return $pages;
}

/**
 * Determine which page to show, based on $_GET['page'].
 *
 * @return array{slug: string, file: string|null, title: string, pages: array}
 */
function navigation(): array {
    $pages = getNavigationItems();

    // No pages found
    if (empty($pages)) {
        return [
            'slug'  => 'none',
            'file'  => null,
            'title' => 'No Pages Found',
            'pages' => [],
        ];
    }

    $firstSlug   = array_key_first($pages);
    $currentSlug = $_GET['page'] ?? $firstSlug;

    if (!isset($pages[$currentSlug])) {
        $currentSlug = $firstSlug;
    }

    $currentFile  = $pages[$currentSlug]['path'];
    $currentTitle = $pages[$currentSlug]['title'];

    $totals = getCollectionTotals();

    return [
        'slug'  => $currentSlug,
        'file'  => $currentFile,
        'title' => $currentTitle,
        'pages' => $pages,
        'totals' => $totals,
    ];
}

/**
 * Absolute path to the manifest file that tracks processed HTML.
 */
function getManifestPath(): string {
    // engine.php -> app/php -> ../../html/processed/manifest.json
    return __DIR__ . '/../../html/processed/manifest.json';
}

/**
 * Load manifest JSON from disk.
 *
 * @return array<string, array<string, mixed>>
 */
function loadManifest(): array {
    $path = getManifestPath();

    if (!is_file($path)) {
        return [];
    }

    $json = file_get_contents($path);
    if ($json === false) {
        return [];
    }

    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

/**
 * Calculate total MSRP values and item counts from the manifest.
 *
 * Iterates through all processed collection entries and aggregates
 * per-category and grand totals based on stored metadata.
 *
 * @return array{
 *   categories: array<string, array{label: string, item_count: int, msrp_total: float}>,
 *   grand_items: int,
 *   grand_msrp: float
 * } Summary of collection totals grouped by category.
 */
function getCollectionTotals(): array {
    $manifest = loadManifest();

    $categories  = [];
    $grandItems  = 0;
    $grandMsrp   = 0.0;

    foreach ($manifest as $slug => $entry) {
        // We need at least a category and msrp_total to count this entry
        if (
            empty($entry['category']) ||
            !isset($entry['msrp_total']) ||
            !isset($entry['item_count'])
        ) {
            continue;
        }

        $key       = (string) $entry['category'];               // e.g. "CDs", "Blu-Ray"
        $label     = (string) ($entry['categoryLabel'] ?? $key); // display label
        $itemCount = (int) ($entry['item_count'] ?? 0);
        $msrpTotal = (float) $entry['msrp_total'];

        if (!isset($categories[$key])) {
            $categories[$key] = [
                'label'      => $label,
                'item_count' => 0,
                'msrp_total' => 0.0,
            ];
        }

        $categories[$key]['item_count'] += $itemCount;
        $categories[$key]['msrp_total'] += $msrpTotal;

        $grandItems += $itemCount;
        $grandMsrp  += $msrpTotal;
    }

    // Optional: sort categories by label for nicer output
    uasort($categories, static function (array $a, array $b): int {
        return strcasecmp($a['label'], $b['label']);
    });

    return [
        'categories'  => $categories,
        'grand_items' => $grandItems,
        'grand_msrp'  => $grandMsrp,
    ];
}

/**
 * Save manifest array back to disk.
 *
 * @param array<string, array<string, mixed>> $manifest
 */
function saveManifest(array $manifest): void {
    $path = getManifestPath();
    $dir  = dirname($path);

    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }

    file_put_contents(
        $path,
        json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );
}

/**
 * Load prices configuration from /prices.json.
 *
 * @return array<string, array<string, mixed>>
 */
function getPricesConfig(): array {
    $path = __DIR__ . '/../../prices.json';

    if (!is_file($path)) {
        return [];
    }

    $json = file_get_contents($path);
    if ($json === false) {
        return [];
    }

    $data = json_decode($json, true);

    return is_array($data) ? $data : [];
}

/**
 * Try to match a filename/slug to one of the price config entries.
 *
 * @param string $slug  e.g. "blu-ray-collection.html" or "blu-ray-collection"
 * @param array<string, array<string, mixed>> $prices
 * @return array{key: string, label: string, msrp: float}|null
 */
function matchPriceConfig(string $slug, array $prices): ?array {
    $haystack = strtolower($slug);

    foreach ($prices as $keyword => $info) {
        $needle = strtolower($keyword);

        if (strpos($haystack, $needle) !== false) {
            $label = $info['label'] ?? $keyword;
            $msrp  = isset($info['MSRP']) ? (float) $info['MSRP'] : 0.0;

            return [
                'key'   => $keyword,
                'label' => $label,
                'msrp'  => $msrp,
            ];
        }
    }

    return null;
}

/**
 * Given a raw HTML file, return the path to a processed file that
 * contains only the <table>...</table> part.
 *
 * It will:
 *  - check manifest + mtime
 *  - regenerate processed file if needed
 *  - count table rows
 *  - detect matching category from prices.json
 *  - compute MSRP totals
 *  - update manifest
 *
 * @return string|null  Path to processed file or null on failure
 */
function getProcessedFilePath(string $rawPath): ?string {
    if (!is_file($rawPath)) {
        return null;
    }

    $manifest = loadManifest();
    $slug     = basename($rawPath);          // e.g. blu-ray-collection.html
    $mtime    = filemtime($rawPath) ?: 0;

    // If we have an up-to-date entry and processed file exists, reuse it
    if (isset($manifest[$slug])) {
        $entry = $manifest[$slug];

        if (
            isset($entry['mtime'], $entry['processed']) &&
            (int) $entry['mtime'] === $mtime &&
            is_file($entry['processed'])
        ) {
            return $entry['processed'];
        }
    }

    // Need to (re)process the raw HTML
    $html = file_get_contents($rawPath);
    if ($html === false) {
        return null;
    }

    // Parse HTML and extract first <table>
    $dom = new DOMDocument();
    $prevUseInternal = libxml_use_internal_errors(true);
    $dom->loadHTML($html);
    libxml_clear_errors();
    libxml_use_internal_errors($prevUseInternal);

    $tables = $dom->getElementsByTagName('table');
    $table  = $tables->item(0);

    if (!$table) {
        // No table found – nothing to process
        return null;
    }

    // Count table rows (all <tr> inside this table)
    $rows      = $table->getElementsByTagName('tr');
    $itemCount = max(0, $rows->length - 1);

    // Extract only the table HTML
    $tableHtml = $dom->saveHTML($table);
    if ($tableHtml === false) {
        return null;
    }

    // Save processed file with same name in html/processed/
    $processedDir = __DIR__ . '/../../html/processed';
    if (!is_dir($processedDir)) {
        mkdir($processedDir, 0775, true);
    }

    $processedPath = $processedDir . '/' . $slug;
    file_put_contents($processedPath, $tableHtml);

    // --- MSRP calculation ---
    $prices   = getPricesConfig();
    $match    = matchPriceConfig($slug, $prices);
    $category = null;
    $label    = null;
    $msrpPer  = 0.0;
    $msrpTotal = 0.0;

    if ($match !== null && $itemCount > 0) {
        $category  = $match['key'];
        $label     = $match['label'];
        $msrpPer   = $match['msrp'];
        $msrpTotal = $itemCount * $msrpPer;
    }

    // --- Update manifest with extended info ---
    $manifest[$slug] = [
        'source'        => $rawPath,
        'processed'     => $processedPath,
        'mtime'         => $mtime,
        'category'      => $category,      // e.g. "Blu-Ray"
        'categoryLabel' => $label,         // e.g. "Blu-Rays"
        'item_count'    => $itemCount,     // number of rows detected
        'msrp_per_item' => $msrpPer,       // price per item
        'msrp_total'    => $msrpTotal,     // total for this file
    ];

    saveManifest($manifest);

    return $processedPath;
}
