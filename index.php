<?php
$pdo = require "pdo.php";

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$totalStatement = $pdo->query("SELECT COUNT(*) FROM posts");
$totalPosts = $totalStatement->fetchColumn();
$totalPages = ceil($totalPosts / $limit);
$statement = $pdo->prepare("SELECT * FROM posts ORDER BY created_at DESC LIMIT :limit OFFSET :offset");
$statement->bindValue(':limit', $limit, PDO::PARAM_INT);
$statement->bindValue(':offset', $offset, PDO::PARAM_INT);
$statement->execute();
$posts = $statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Blog</title>
</head>
<body class="bg-gray-100">
<header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold">My Blog</h1>
    </div>
</header>

<div class="container mx-auto p-4 mt-4">
    <?php foreach ($posts as $post): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <a href="edit.php?id=<?= htmlspecialchars_decode($post['id']) ?>" class="block">
                <div class="p-4">
                    <h2 class="text-xl font-semibold">
                        <?= htmlspecialchars_decode($post['title']) ?>
                    </h2>
                    <p class="text-gray-700 text-lg mt-4"><?= nl2br(htmlspecialchars_decode($post['body'])) ?></p>
                    <p class="text-sm text-gray-500 mt-4">
                        Last edited: <?= htmlspecialchars_decode($post['updated_at']) ?>
                    </p>
                </div>
            </a>
        </div>
    <?php endforeach ?>

    <!-- Pagination -->
    <div class="flex justify-between items-center mt-10">
        <a
                href="?page=<?= max(1, $page - 1) ?>"
                class="bg-blue-500 text-white px-6 py-4 rounded hover:bg-blue-600 focus:outline-none <?= $page <= 1 ? 'opacity-50 pointer-events-none' : '' ?>">
            Previous
        </a>
        <?php if ($page > $totalPages): ?>
            <span class="text-gray-700 text-lg">This Page Not Found!</span>
        <?php else: ?>
            <span class="text-gray-700 text-lg">Page <?= $page ?> of <?= $totalPages ?></span>
        <?php endif ?>
        <a
                href="?page=<?= min($totalPages, $page + 1) ?>"
                class="bg-blue-500 text-white px-6 py-4 rounded hover:bg-blue-600 focus:outline-none <?= $page >= $totalPages ? 'opacity-50 pointer-events-none' : '' ?>">
            Next
        </a>
    </div>

    <!-- Create Post Button -->
    <div class="mt-6 text-center">
        <a href="create.php" class="bg-green-500 text-white px-6 py-4 rounded hover:bg-green-600 focus:outline-none">
            Create New Post
        </a>
    </div>
</div>
</body>
</html>