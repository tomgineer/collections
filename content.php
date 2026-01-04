<!-- Page Content -->
<main class="flex justify-center px-4 my-8 pb-16 lg:pb-24 flex-1">
    <div class="w-full max-w-3xl overflow-x-auto">
        <h1 class="text-xl lg:text-3xl font-bold mb-4 text-accent">
            <?= htmlspecialchars($nav['title']) ?>
        </h1>

        <?php if ($nav['file'] !== null): ?>
            <?php include $nav['file']; ?>
        <?php endif; ?>

    </div>
</main>