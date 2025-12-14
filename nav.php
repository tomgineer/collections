<!-- Navigation -->
<nav class="lg:sticky lg:top-0 lg:z-40 w-full bg-base-200/80 backdrop-blur border-b border-base-300 shadow-sm">
    <div class="max-w-screen-lg mx-auto flex flex-wrap items-center justify-between px-4 py-3">
        <a href="./" class="text-lg font-semibold text-base-content tracking-wide flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-base-content/65">
                <circle cx="12" cy="12" r="9" />
                <circle cx="12" cy="12" r="2" />
            </svg>
            <span class="tracking-tighter">My Collections</span>
        </a>

        <ul class="menu lg:menu-horizontal bg-transparent gap-1">
            <?php foreach ($nav['pages'] as $slug => $info): ?>
                <?php
                $isActive = $slug === $nav['slug']
                    ? 'active text-accent font-semibold bg-base-100'
                    : 'hover:bg-base-300/40';
                $href = '?page=' . urlencode($slug);
                ?>
                <li>
                    <a href="<?= $href ?>" class="<?= $isActive ?> rounded-md px-3 py-2 transition-colors duration-200">
                        <?= htmlspecialchars($info['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>