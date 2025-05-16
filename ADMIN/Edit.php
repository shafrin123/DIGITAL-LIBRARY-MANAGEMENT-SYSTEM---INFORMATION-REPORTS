<?php
include 'db_connection.php';  // Include database connection

// Initialize variables
$id = $name = $mail = $phone = $class = $year = "";

// Fetch existing student data
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM stureg WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $mail = $row['mail'];
        $phone = $row['phone'];
        $class = $row['class'];
        $year = $row['year'];
    } else {
        echo "No student found with ID: $id";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $year = $_POST['year'];

    // Update the student record
    $sql = "UPDATE stureg SET name='$name', mail='$mail', phone='$phone', class='$class', year='$year' WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Student updated successfully!'); window.location.href='Student Info.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>

<h2>Edit Student</h2>

<form action="Edit.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $name; ?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="mail" value="<?php echo $mail; ?>" required><br><br>

    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo $phone; ?>" required><br><br>

    <label>Class:</label>
    <input type="text" name="class" value="<?php echo $class; ?>" required><br><br>

    <label>Year:</label>
    <input type="number" name="year" value="<?php echo $year; ?>" required><br><br>

    <button type="submit">Update</button>
    <a href="Student Info.php"><button type="button">Cancel</button></a>
</form>

</body>
</html>

