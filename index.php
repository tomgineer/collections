<?php
declare(strict_types=1);

include __DIR__ . '/app/php/engine.php';

// Get all navigation data
$nav = navigation();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($nav['title']) ?> – My Collections</title>
    <?php include __DIR__ . '/app/php/favicon.php'; ?>

    <!-- Fonts & Styles -->
    <link href="app/fonts/style.css" rel="stylesheet">
    <link href="app/css/tailwind.css?v=3.0" rel="stylesheet">
</head>

<body class="font-sans">

    <!-- Navigation -->
    <?php include __DIR__ . '/nav.php'; ?>

    <!-- Page Content -->
    <?php include __DIR__ . '/content.php'; ?>

    <!-- Footer -->
    <?php include __DIR__ . '/footer.php'; ?>

    <!-- Scripts -->
    <script src="app/js/scripts.js?v=2.1" defer></script>
</body>

</html>
