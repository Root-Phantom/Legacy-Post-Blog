<?php
$pdo = require("pdo.php");
$errors = [];
$id = isset($_GET['id']) ? $_GET['id'] : null;
if (!$id) {
    header("Location: index.php");
    exit;
}
$statement = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

if (!$post) {
    header("Location: index.php");
    exit;
}

$title = $post['title'];
$body = $post['body'];

$isPutRequest = $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT';

if ($isPutRequest) {
    $title = trim(isset($_POST["title"]) ? $_POST["title"] : '');
    $body = trim(isset($_POST["body"]) ? $_POST["body"] : '');

    if (empty($title)) {
        $errors['title'] = "The title field is required.";
    }
    if (empty($body)) {
        $errors['body'] = "The body field is required.";
    }

    if (empty($errors)) {
        $title = htmlspecialchars($title);
        $body = htmlspecialchars($body);

        $sql = "UPDATE posts SET title = :title, body = :body WHERE id = :id";
        $params = [
            'title' => $title,
            'body' => $body,
            'id' => $id
        ];

        $statement = $pdo->prepare($sql);
        $statement->execute($params);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Blog</title>
</head>
<body class="bg-gray-100">
<header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold">Update Blog Post</h1>
    </div>
</header>

<div class="flex justify-center mt-10">
    <div class="bg-white rounded shadow-md p-8 w-full max-w-md">
        <h1 class="text-2xl font-semibold mb-6">Update Blog Post</h1>
        <form method="post" action="">
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Title</label>
                <input type="text" id="title" name="title" value="<?= htmlspecialchars(isset($_POST['title']) ? $_POST['title'] : $post['title']) ?>"
                       placeholder="Enter the post title"
                       class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none">
                <?php if (isset($errors['title'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['title'] ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label for="body" class="block text-gray-700 font-medium">Body</label>
                <textarea id="body" name="body" placeholder="Enter the post body"
                          class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none"><?= htmlspecialchars(isset($_POST['body']) ? $_POST['body'] : $post['body']) ?></textarea>
                <?php if (isset($errors['body'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['body'] ?></p>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none w-full">
                    Update
                </button>
            </div>
        </form>

        <div class="mb-4">
            <form action="delete.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">
                <input type="hidden" name="_method" value="DELETE">
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none w-full">
                    Delete
                </button>
            </form>
        </div>

        <div class="mt-4">
            <a href="index.php" class="text-blue-500 hover:underline w-full text-center block">
                Back to posts
            </a>
        </div>
    </div>
</div>
</body>
</html>