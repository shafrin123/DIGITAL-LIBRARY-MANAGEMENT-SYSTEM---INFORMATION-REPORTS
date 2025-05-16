<?php
$connection = mysqli_connect("localhost:3306", "root", "");
$db = mysqli_select_db($connection, 'login');
include "connection.php";
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
    <link rel="stylesheet" href="BookAvail.css">
    
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

    <title>BookAvail</title> 
</head>
<body>
    <nav>
    <nav class="sidebar">
    <div class="logo-name">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            
        </div>

        <div class="menu-items">
            <ul class="nav-links">
            <li><a href="Dash.php"><i class="bx bx-home"></i><span class="link-name">Dashboard</span></a></li>
                <li><a href="Student Reg.php"><i class="bx bx-user-plus"></i><span class="link-name">Student Registration</span></a></li>
                <li><a href="Staff.php"><i class="bx bx-user"></i><span class="link-name">Staff Registration</span></a></li>
                <li><a href="Book Reg.php"><i class="bx bx-book-add"></i><span class="link-name">Book Registration</span></a></li>
                <li><a href="BookAvail.php"><i class="bx bx-book"></i><span class="link-name">Book Availability</span></a></li>
                <li><a href="Bookissue.php"><i class="bx bx-book-reader"></i><span class="link-name">Book Issue</span></a></li>
                <li><a href="BookReturn.php"><i class="bx bx-file"></i><span class="link-name">Book Return</span></a></li>
                <li><a href="Book Report.php"><i class="bx bx-file"></i><span class="link-name">Book Report</span></a></li>
                <li><a href="Student Info.php"><i class="bx bx-group"></i><span class="link-name">Student Info</span></a></li>
                <li><a href="Staff Info.php"><i class="bx bx-id-card"></i><span class="link-name">Staff Info</span></a></li>
                <li><a href="Book Info.php"><i class="bx bx-id-card"></i><span class="link-name">Book Info</span></a></li>
                <li><a href="FineDisplay.php"><i class="bx bx-money"></i><span class="link-name">Fine Details</span></a></li>
                <li>
                    <a href="prebooking.php">
                        <i class="bx bx-notification"></i>
                        <span class="link-name">Notification</span>
                        <span class="badge" id="notificationCount" style="display: none;">0</span>
                    </a>
                </li>
               
                <li><a href="profile.php"><i class="bx bx-user-circle"></i><span class="link-name">My Account</span></a></li>
</ul>
        </div>
        <i class="bx bx-menu sidebar-toggle"></i>
    </nav>

    <section class="dashboard">
        
        <div class="top">
        <i class="uil uil-bars sidebar-toggle"></i>
            
        </div>
        <br>
        <br>
        <br>
    
  

            <div class="activity">
                <div class="location">
                    <header>Book Availability</header>
                    <form method="post">
                        <label>Book Name*</label>
                        <input type="text" name="name" placeholder="Name" >
                        <input type="submit" name="get_details" value="Get Details">
                        <input type="submit" name="show_all" value="Show All Books">
                        <input type="submit" name="available_quantity" value="Available Quantity">
                    </form>
                    <br>

                    <?php
                    // Get the selected book name from the form
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["get_details"])) {
                        $name = $_POST["name"];
                        // Fetch book details
                        $sql = "SELECT * FROM booksss WHERE name = ?";
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
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['author']}</td>
                                <td>{$row['price']}</td>
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
                        $sql = "SELECT * FROM booksss ORDER BY create_time DESC";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Author</th><th>Price</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['author']}</td>
                                <td>{$row['price']}</td>
                              </tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "<p style='color:red;'>No books found in the database.</p>";
                        }
                    }

                    // Show available quantity of books
                    if (isset($_POST["available_quantity"])) {
                        $sql = "SELECT access_no, name, avail_quantity, total_quantity FROM booksss";
                        $result = $connection->query($sql);
                        if ($result->num_rows > 0) {
                            echo "<table class='table'>";
                            echo "<tr><th>Access No</th><th>Book Name</th><th>Available Quantity</th><th>Total Quantity</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$row['access_no']}</td>
                                <td>{$row['name']}</td>
                                <td>{$row['avail_quantity']}</td>
                                <td>{$row['total_quantity']}</td>
                              </tr>";
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

    <script src="JAVA.js"></script>
</body>
</html>