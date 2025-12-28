<!-- Navigation -->
<nav class="z-999 w-full bg-base-200/80">
    <div class="navbar lg:max-w-4xl mx-auto px-4">
        <div class="flex-1">
            <a href="./" class="text-lg font-semibold text-base-content tracking-wide flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-6 text-base-content/70">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    <path d="M7 12a5 5 0 0 1 5 -5" />
                    <path d="M12 17a5 5 0 0 0 5 -5" />
                </svg>
                <span class="tracking-tighter">My Collections</span>
            </a>
        </div>
        <div class="flex-none">
            <div class="dropdown dropdown-end lg:hidden">
                <label tabindex="0" class="btn btn-sm btn-accent">
                    Menu
                </label>
                <ul tabindex="0" class="menu dropdown-content mt-3 w-56 rounded-box bg-base-200 p-2 border-2 border-accent">
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

            <ul class="menu menu-horizontal hidden lg:flex bg-transparent gap-1">
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
    </div>
</nav>