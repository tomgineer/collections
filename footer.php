<?php if (!empty($nav['totals']) && !empty($nav['totals']['categories'])): ?>
    <?php
    $footerSvgs = [
        'fallback' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M7 12a5 5 0 0 1 5 -5" /><path d="M12 17a5 5 0 0 0 5 -5" /></svg>
SVG,
        'books' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 19a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6a9 9 0 0 1 9 0a9 9 0 0 1 9 0" /><path d="M3 6l0 13" /><path d="M12 6l0 13" /><path d="M21 6l0 13" /></svg>
SVG,
        'arkas collection' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5.5 3a3.5 3.5 0 0 1 3.25 4.8a7.017 7.017 0 0 0 -2.424 2.1a3.5 3.5 0 1 1 -.826 -6.9z" /><path d="M18.5 3a3.5 3.5 0 1 1 -.826 6.902a7.013 7.013 0 0 0 -2.424 -2.103a3.5 3.5 0 0 1 3.25 -4.799z" /><path d="M12 14m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /></svg>
SVG,
        'blu-rays' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" /><path d="M8 4l0 16" /><path d="M16 4l0 16" /><path d="M4 8l4 0" /><path d="M4 16l4 0" /><path d="M4 12l16 0" /><path d="M16 8l4 0" /><path d="M16 16l4 0" /></svg>
SVG,
        'total' => <<<'SVG'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-10 text-info"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
SVG,
    ];

    ?>

    <footer class="w-full bg-base-200 text-base-content/70 mt-12 py-6 pb-12">
        <div class="stats flex flex-wrap justify-center items-start gap-4">
            <?php foreach ($nav['totals']['categories'] as $key => $cat): ?>
                <?php
                $lookupKey = strtolower((string) $key);
                $labelKey = strtolower(trim((string) ($cat['label'] ?? '')));
                $iconSvg = $footerSvgs[$labelKey] ?? $footerSvgs['fallback'];
                $descText = (string) ($cat['desc'] ?? '');
                $descTextExt = (string) ($cat['desc_ext'] ?? '');

                if ($lookupKey === 'total') {
                    $iconSvg = $footerSvgs['total'] ?? $footerSvgs['fallback'];
                    $descText = 'All categories';
                    $descTextExt = '';
                }
                ?>
                <div class="stat flex-0 border-r-0 xl:border-r xl:last:border-r-0">
                    <div class="stat-figure text-secondary">
                        <?= $iconSvg ?>
                    </div>
                    <div class="stat-title text-base"><?= htmlspecialchars($cat['label']) ?></div>
                    <div class="stat-value text-base-content"><?= number_format($cat['msrp_total'], 0, ',', '.') ?> €</div>
                    <div class="stat-desc text-sm"><?= $descText ?></div>
                    <div class="stat-desc text-sm"><?= $descTextExt ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="container px-4">
            <p class="mt-12 text-center lg:text-right text-sm text-base-content/60">
                Collections Version: <span class="text-info"><?= COLLECTIONS_VERSION ?></span>.
                <a
                    href="https://github.com/tomgineer/collections"
                    target="_blank"
                    rel="noopener noreferrer nofollow"
                    class="ml-1 underline underline-offset-4 decoration-info hover:decoration-secondary hover:text-base-content/80 focus:outline-none focus-visible:ring-2 focus-visible:ring-primary/60 rounded">Visit on GitHub</a>
            </p>
        </div>

    </footer>
<?php endif; ?>