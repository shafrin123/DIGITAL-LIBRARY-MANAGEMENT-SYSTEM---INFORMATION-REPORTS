<?php
// db.php
$host = 'localhost'; // Database host
$dbname = 'user'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch books based on the selected category
$books = [];
if (isset($_GET['category'])) {
    $category = $_GET['category'];

    try {
        $stmt = $conn->prepare("SELECT * FROM booksss WHERE categories = :category");
        $stmt->bindParam(':category', $category);
        $stmt->execute();

        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debugging output to verify query execution
        if (empty($books)) {
            echo "<p>No books found for category: " . htmlspecialchars($category) . "</p>";
        }
    } catch (PDOException $e) {
        echo "<p>Error fetching books: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p>Category not specified in the URL.</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books by Category</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="Categories.css">
</head>
<body>
<header>
    <a href="Categories.php" class="brand">Back to Categories</a>
</header>
<div class="container">
    <h1>Books in Category: <?php echo htmlspecialchars($_GET['category'] ?? 'Unknown'); ?></h1>
    <?php if (!empty($books)): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Price</th>
                    <th>Total Quantity</th>
                    <th>Available Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($book['name']); ?></td>
                        <td><?php echo htmlspecialchars($book['author']); ?></td>
                        <td><?php echo htmlspecialchars($book['price']); ?></td>
                        <td><?php echo htmlspecialchars($book['total_quantity']); ?></td>
                        <td><?php echo htmlspecialchars($book['avail_quantity']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No books found in this category.</p>
    <?php endif; ?>
</div>
</body>
</html>
