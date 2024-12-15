<?php
$pdo = require('pdo.php');
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $title = htmlspecialchars(trim($_POST['title']));
    $body = htmlspecialchars(trim($_POST['body']));
    if (empty($title)) {
        $errors['title'] = "The title field is required.";
    }
    if (empty($body)) {
        $errors['body'] = "The body field is required.";
    }

    if (empty($errors)) {
        $title = htmlspecialchars($title);
        $body = htmlspecialchars($body);

        $statement = $pdo->prepare("INSERT INTO posts (title, body) VALUES (:title, :body)");
        $params = [
            'title' => $title,
            'body' => $body
        ];
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
    <title>Create Blog Post</title>
</head>
<body class="bg-gray-100">
<header class="bg-blue-500 text-white p-4">
    <div class="container mx-auto">
        <h1 class="text-3xl font-semibold">Create Blog Post</h1>
    </div>
</header>

<div class="flex justify-center mt-10">
    <div class="bg-white rounded shadow-md p-8 w-full max-w-md">
        <h1 class="text-2xl font-semibold mb-6">Create Blog Post</h1>
        <form method="post">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-medium">Title</label>
                <input type="text" id="title" name="title"
                       value="<?= htmlspecialchars(isset($title) ? $title : '') ?>"
                       placeholder="Enter the post title"
                       class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none">
                <?php if (isset($errors['title'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['title'] ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="body" class="block text-gray-700 font-medium">Body</label>
                <textarea id="body" name="body" placeholder="Enter the post body"
                          class="w-full px-4 py-2 border rounded focus:ring focus:ring-blue-300 focus:outline-none"><?= htmlspecialchars(isset($body) ? $body : '') ?></textarea>
                <?php if (isset($errors['body'])): ?>
                    <p class="text-red-500 text-sm mt-1"><?= $errors['body'] ?></p>
                <?php endif; ?>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" name="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none">
                    Submit
                </button>
                <a href="index.php" class="text-blue-500 hover:underline">Back to posts</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>