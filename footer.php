<?php if (!empty($nav['totals']) && !empty($nav['totals']['categories'])): ?>

    <footer class="w-full bg-base-200 text-base-content/70 border-t border-base-300 mt-12 py-6">
        <div class="max-w-screen-lg mx-auto px-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <!-- Per-category totals as a list -->
            <ul class="flex flex-col sm:flex-row sm:flex-wrap items-center justify-center gap-x-4 gap-y-2 sm:justify-start text-sm list-none m-0 p-0">
                <?php foreach ($nav['totals']['categories'] as $cat): ?>
                    <li>
                        <span class="font-medium"><?= htmlspecialchars($cat['label']) ?>:</span>
                        <span class="text-accent"><?= number_format($cat['msrp_total'], 0, ',', '.') ?> €</span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Grand total -->
            <?php if (!empty($nav['totals']['grand_msrp'])): ?>
                <div class="text-center sm:text-right font-semibold text-lg">
                    Total MSRP: <span class="text-warning"><?= number_format($nav['totals']['grand_msrp'], 0, ',', '.') ?> €</span>
                </div>
            <?php endif; ?>
        </div>
    </footer>

<?php endif; ?>