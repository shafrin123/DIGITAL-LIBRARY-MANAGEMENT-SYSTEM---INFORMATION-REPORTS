<?php
session_name("user_session");
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: UserLogin.php");
    exit();
}

// Connect to the database
$connection = mysqli_connect("localhost:3306", "root", "", "login");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$email = $_SESSION['email'];

// Check if the user exists
$sql_user_check = "SELECT * FROM logins WHERE email = '$email'";
$result_user_check = mysqli_query($connection, $sql_user_check);

if (mysqli_num_rows($result_user_check) == 0) {
    echo "<p>User does not exist.</p>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hive - Fine Details</title>
    <link rel="stylesheet" href="MAIN.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        h2 {
            text-align: center;
            margin-top: 40px;
        }
        p {
            text-align: center;
            color: red;
        }
    </style>
</head>
<body>

    <header>
        <a href="#" class="brand">Book Hive</a>
        <div class="menu-btn"></div>
        <div class="navigation">
            <a href="#main">Home</a>
            <a href="Bookavail.php">Pre-booking</a>
            <a href="Categories.php">Book Categories</a>
            <a href="#services">Library Information</a>
            <a href="#profile">Profile</a>
        </div>
    </header>

    <section class="fine-details" id="fine-details">
        <h2>Fine & Due Date Details</h2>
        <div class="content">
            <?php
            $sql = "SELECT b.book_name, bi.due_date, bi.fine_amount 
                    FROM book_issues bi
                    JOIN bookss b ON bi.access_no = b.access_no
                    WHERE bi.email = '$email'";
            $result = mysqli_query($connection, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo "<table>";
                echo "<tr><th>Book Name</th><th>Due Date</th><th>Fine Amount (₹)</th></tr>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['book_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fine_amount']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>You currently have no borrowed books with due dates.</p>";
            }

            mysqli_close($connection);
            ?>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({ offset: 0 });

      const menuBtn = document.querySelector(".menu-btn");
      const navigation = document.querySelector(".navigation");
      const navigationItems = document.querySelectorAll(".navigation a");

      menuBtn.addEventListener("click", () => {
          menuBtn.classList.toggle("active");
          navigation.classList.toggle("active");
      });

      window.addEventListener("scroll", function () {
          const header = document.querySelector("header");
          header.classList.toggle("sticky", window.scrollY > 0);
      });

      navigationItems.forEach((item) => {
          item.addEventListener("click", () => {
              menuBtn.classList.remove("active");
              navigation.classList.remove("active");
          });
      });
    </script>

</body>
</html>
