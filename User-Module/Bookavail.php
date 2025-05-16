<?php
session_name("user_session");
session_start(); // Ensure session is started

$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');

// Check if the user is logged in and fetch the username
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $sql = "SELECT username FROM login WHERE email = ?";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['username'] = $row['username'];
        } else {
            $_SESSION['username'] = "Guest"; // Fallback if no user found
        }
        $stmt->close();
    } else {
        $_SESSION['username'] = "Guest"; // Fallback if query fails
    }
} else {
    $_SESSION['username'] = "Guest"; // Fallback if not logged in
}

include "connect.php";
// Remove duplicate include
// include("connection.php"); 
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="Bookavil.css">
    
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <title>BookAvail</title> 
</head>
<body>
<header>
        <a href="" class="brand" data-aos="zoom-in" data-aos-duration="1000">Book Hive</a>
        <div class="menu-btn"></div>
        <div class="navigation">
            <a href="#main" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="100">Home</a>
            <a href="Bookavail.php"data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">Pre-booking</a>
            <a href="Categories.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">Book Categories</a>
            <a href="#services" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">Library Information</a>
            <a href="Feed.php" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">Feedback</a>
            
            
            
            
        </div>

        <style>
            header{
    z-index: 889;
    position: fixed;
    background-color: transparent;
    top: 0;
    left: 0;
    width: 100%;
    padding: 15px 200px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: 0.2s ease;
}

header.sticky{
    background-color: #0a0a0a;
    padding: 10px 200px;
}

header .brand{
    color: white;
    font-size: 1.8em;
    font-weight: 700;
    text-transform: uppercase;
    text-decoration: none;
}

header .navigation{
    position: relative;
}

header .navigation a{
    color: white;
    font-size: 1em;
    text-decoration: none;
    font-weight: 500;
    margin-left: 30px;
}

header .navigation a:hover{
    color: #3a6cf4;
}

header .sticky .navigation a:hover{
    color: black;
}
</style>
    </header>

<!-- Popup form for prebooking -->
<div id="prebookPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Pre-Book a Book</h2>
        <form method="post" id="prebookForm">
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
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" placeholder="Enter Your Name" required readonly>
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
                <input type="text" id="book_name" name="book_name" placeholder="Enter Book Name" required readonly>
            </div>
            <div class="form-group">
                <label for="author_name">Author Name:</label>
                <input type="text" id="author_name" name="author_name" placeholder="Enter Author Name" required readonly>
            </div>
            <button type="button" onclick="submitPrebook()">Pre-Book</button>
        </form>
        <p id="successMessage" style="color: green; display: none;">Pre-booking successful!</p>
    </div>
</div>

            <div class="activity">
                <div class="location">
                    <header>Book Availability</header>
                  
                    <form method="post">
                        <label>Book Name*</label>
                        <input type="text" name="name" placeholder="Name" >
                        <input type="submit" name="get_details" value="Get Details">
                        <input type="submit" name="available_quantity" value="Available Quantity">
                       
                    </form>
                    <br>

                    <?php
                    // Get the selected book name from the form
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["get_details"])) {
                        $name = $_POST["name"];
                        // Fetch book details
                        $sql = "SELECT access_no, book_name, author, price FROM bookss WHERE book_name = ?"; // Ensure 'author' is included in the SELECT query
                        $stmt = $connection->prepare($sql);
                        if ($stmt === false) {
                            die("Prepare failed: " . $connection->error);
                        }

                        $stmt->bind_param("s", $name);
                        if (!$stmt->execute()) {
                            die("Execute failed: " . $stmt->error);
                        }

                        $result = $stmt->get_result();
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th><th>Action</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                $author = isset($row['author']) ? $row['author'] : "Unknown"; // Handle missing 'author' key
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['book_name']}</td>
                                <td>{$author}</td>
                                <td>{$row['price']}</td>
                                <td><a href='#' onclick='openPopup(\"{$row['access_no']}\", \"{$row['book_name']}\", \"{$author}\")'>Pre-Book</a></td>
                              </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p style='color:red;'>No book found with the given name.</p>";
                        }
                        $stmt->close();
                    }

                    // Show all books
                    if (isset($_POST["show_all"])) {
                        $sql = "SELECT * FROM bookss ORDER BY create_time DESC";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th><th>Action</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                $author = isset($row['author']) ? $row['author'] : "Unknown"; // Handle missing 'author' key
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['name']}</td>
                                <td>{$author}</td>
                                <td>{$row['price']}</td>
                                <td><a href='#' onclick='openPopup(\"{$row['access_no']}\", \"{$row['name']}\", \"{$author}\")'>Pre-Book</a></td>
                              </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p style='color:red;'>No books found in the database.</p>";
                        }
                    }

                    // Show available quantity of books
                    if (isset($_POST["available_quantity"])) {
                        $sql = "SELECT access_no, book_name, avail_quantity, total_quantity, author FROM bookss";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Available Quantity</th><th>Total Quantity</th><th>Action</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                $author = isset($row['author']) ? $row['author'] : "Unknown"; // Handle missing 'author' key
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['book_name']}</td>
                                <td>{$row['avail_quantity']}</td>
                                <td>{$row['total_quantity']}</td>
                                <td>";
                                if ($row['avail_quantity'] > 0) {
                                    echo "<a href='#' onclick='openPopup(\"{$row['access_no']}\", \"{$row['book_name']}\", \"{$author}\")'>Pre-Book</a>";
                                } else {
                                    echo "<span style='color:red;'>Not Available</span>";
                                }
                                echo "</td></tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p style='color:red;'>No books found in the database.</p>";
                        }
                    }
                    
                    ?>
                </div>
            </div>
        </section>

    <script>
        // JavaScript for handling popup and form submission
        function openPopup(accessNo, bookName, authorName) {
            document.getElementById("prebookPopup").style.display = "block";
            document.getElementById("successMessage").style.display = "none";

            // Automatically populate form fields
            document.getElementById("book_name").value = bookName;
            document.getElementById("author_name").value = authorName; // Ensure authorName is passed and set here

            // Assuming the user's name is stored in a session variable and passed via PHP
            document.getElementById("name").value = "<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>";
        }

        function closePopup() {
            document.getElementById("prebookPopup").style.display = "none";
        }

        function toggleFields() {
            var userType = document.getElementById("user_type").value;
            document.getElementById("studentFields").style.display = (userType == "Student") ? "block" : "none";
            document.getElementById("staffFields").style.display = (userType == "Staff") ? "block" : "none";
        }

        function submitPrebook() {
            const form = document.getElementById("prebookForm");
            const formData = new FormData(form);

            fetch("PRE-booking.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("successMessage").style.display = "block";
                form.reset();
                toggleFields(); // Reset conditional fields
            })
            .catch(error => console.error("Error:", error));
        }
    </script>

    <style>
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
</body>
</html>