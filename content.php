<!-- Page Content -->
<main class="flex justify-center px-4 my-4 lg:my-16 pb-16 lg:pb-24">
    <div class="w-full max-w-[80ch] overflow-x-auto">
        <h1 class="text-2xl font-bold mb-4 text-center">
            <?= htmlspecialchars($nav['title']) ?>
        </h1>

        <div role="alert" class="alert alert-success alert-soft mb-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                        d="m4.5 12.75 6 6 9-13.5" />
            </svg>

            <span data-js-count>You own 0 Items.</span>
        </div>

        <?php if ($nav['file'] !== null): ?>
            <?php include $nav['file']; ?>
        <?php endif; ?>
    </div>
</main>