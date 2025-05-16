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

$user_data = mysqli_fetch_assoc($result_user_check);
$name = $user_data['username']; // Assuming 'name' is a column in the 'logins' table
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
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
            font-size: px;
            color: black;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        p {
            text-align: center;
            color: red;
        }

        .user-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px auto;
        }

        .detail-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 250px;
            text-align: center;
        }

        .detail-card h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #4CAF50;
        }

        .detail-card p {
            font-size: 16px;
            color: #333;
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
            <a href="Library Information.php">Library Information</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <section class="fine-details" id="fine-details">
        <h2>WELCOME, <?php echo htmlspecialchars($name); ?>!</h2>
        <div class="content">
            <p>Here are your account details:</p>
            <div class="user-details">
                <?php
                foreach ($user_data as $field => $value) {
                    if ($field === 'password' || $field === 'id' || $field === 'created_at') {
                        continue; // Skip displaying the password, id, and created_at fields
                    }
                    echo "<div class='detail-card'>";
                    echo "<h3>" . htmlspecialchars(ucfirst($field)) . "</h3>";
                    echo "<p>" . htmlspecialchars($value) . "</p>";
                    echo "</div>";
                }
                ?>
            </div>
            <div style="text-align: center; margin-top: 20px;">
                <a href="MAIN.php" style="text-decoration: none; color: blue; font-weight: bold;">View Fine Amount Details</a>
            </div>
        </div>
    </section>

    <!--  About Section -->

    <section class="about" id="about">
        <div class="title reveal">
            <h2 class="section-title" data-aos="fade-up" data-aos-duration="1000">About me</h2>
        </div>
        <div class="content">
            <div class="column col-left reveal">
                <div class="img-card" data-aos="fade-right" data-aos-duration="2000" data-aos-delay="200">
                    <img src="about.png" alt="">
                </div>
            </div>
            <div class="column col-right reveal">
                <h2 class="content-title" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">Welcome to PG Department of Computer Science</h2>
                <p class="paragraph-text" data-aos="flip-up" data-aos-duration="1000" data-aos-delay="400">The Department of Computer Science came into existence from the academic year  <span>2012-13 and is offering B.Sc., and M.Sc.,Computer Science Programmes.</span> Our department  is committed to providing high-quality education in computer science, fostering innovation,  and preparing students for successful careers in the field of technology.<br>At Rajeswari Vedachalam Govt. Arts College, Chengalpattu, our focus is on nurturing the next generation  of computer scientists and empowering them to make meaningful contributions to society</p>
          
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            offset: 0
        });

        const menuBtn = document.querySelector(".menu-btn");
        const navigation = document.querySelector(".navigation");
        const navigationItems = document.querySelectorAll(".navigation a");

        menuBtn.addEventListener("click", () => {
            menuBtn.classList.toggle("active");
            navigation.classList.toggle("active");
        });

        window.addEventListener("scroll", function() {
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