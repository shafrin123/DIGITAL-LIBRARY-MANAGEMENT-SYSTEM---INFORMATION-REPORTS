<?php
session_start();
include 'connect.php';
// Fetch the name of the currently logged-in person
$connection = mysqli_connect("localhost", "root", "", "user");
if (!$connection) {
  die("Connection failed: " . mysqli_connect_error());
}

if (isset($_SESSION['username'])) {
  $email = $_SESSION['username'];
  $sql = "SELECT username FROM login WHERE username = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = $result->fetch_assoc();
  $loggedInName = $row['username'];
  $stmt->close();
} 


$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "login"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userType = $_POST['user_type'];
    $name = $_POST['name'];
    $bookName = $_POST['book_name'];
    $authorName = $_POST['author_name'];
    $class = isset($_POST['class']) ? $_POST['class'] : NULL;
    $department = isset($_POST['department']) ? $_POST['department'] : NULL;

    // Insert booking request into database
    $stmt = $conn->prepare("INSERT INTO pre_bookings (user_type, name, class, department, book_name, author_name, status) VALUES (?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssssss", $userType, $name, $class, $department, $bookName, $authorName);
    $stmt->execute();
    $stmt->close();
}
$conn->close();


?>

<!DOCTYPE html>
<html>
<head>
    <title>Pre-Booking Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px #aaa;
            width: 300px;
        }
        h2 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 0px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #218838;
        }
        .success {
            text-align: center;
            color: green;
            font-weight: bold;
        }
/* Styles for popup */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close-btn {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        .close-btn:hover {
            color: red;
        }

        .popup-content h2 {
            margin-top: 0;
        }

        .popup-content form input[type="text"],
        .popup-content form select,
        .popup-content form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .popup-content form button {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
        }

        .popup-content form button:hover {
            background-color: #218838;
        }
    </style>
    <script>
        function toggleFields() {
            var userType = document.getElementById("user_type").value;
            document.getElementById("studentFields").style.display = (userType == "Student") ? "block" : "none";
            document.getElementById("staffFields").style.display = (userType == "Staff") ? "block" : "none";
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Pre-Booking Form</h2>
        <?php if ($_SERVER["REQUEST_METHOD"] == "POST") echo "<p class='success'>Pre-booking successful. Admin will be notified.</p>"; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="user_type">Select Type:</label>
                <select name="user_type" id="user_type" required onchange="toggleFields()">
                <option value="">Select</option>
                    <option value="Student">Student</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($loggedInName); ?>" readonly>
            </div>
            <div id="studentFields" style="display:none;">
                <div class="form-group">
                    <label for="class">Class:</label>
                    <select name="class" id="class">
                        <option value="BSc">BSc</option>
                        <option value="MSc">MSc</option>
                    </select>
                </div>
            </div>
            <div id="staffFields" style="display:none;">
                <div class="form-group">
                    <label for="department">Department:</label>
                    <select name="department" id="department">
                        <option value="Arts">Arts</option>
                        <option value="Science">Science</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="book_name">Book Name:</label>
                <input type="text" id="book_name" name="book_name" value="">
            </div>
            <div class="form-group">
                <label for="author_name">Author Name:</label>
                <input type="text" id="author_name" name="author_name" value="">
            </div>
            <button type="submit">Pre-Book</button>
        </form>
    </div>
</body>
</html>