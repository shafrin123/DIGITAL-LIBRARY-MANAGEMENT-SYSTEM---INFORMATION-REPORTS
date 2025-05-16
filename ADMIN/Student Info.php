<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM stureg ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Search by exact name
if (isset($_POST['search_name_btn'])) {
    $search_name = isset($_POST['search_name']) ? trim($_POST['search_name']) : '';
    if (!empty($search_name)) {
        $stmt = $conn->prepare("SELECT * FROM stureg WHERE name = ?");
        $stmt->bind_param("s", $search_name);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
if (isset($_POST['show_all'])) {
    $stmt = $conn->prepare("SELECT * FROM stureg");
    $stmt->execute();
    $result = $stmt->get_result();
}

// Search by class and year
if (isset($_POST['search_class_year_btn'])) {
    $class = isset($_POST['class']) ? trim($_POST['class']) : '';
    $year = isset($_POST['year']) ? trim($_POST['year']) : '';

    if (!empty($class) && !empty($year)) {
        $stmt = $conn->prepare("SELECT * FROM stureg WHERE class = ? AND year = ?");
        $stmt->bind_param("ss", $class, $year);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}

// Fetch student details for editing if an ID is provided
$editStudent = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM stureg WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $editStudent = $stmt->get_result()->fetch_assoc();
}

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $year = $_POST['year'];

    $stmt = $conn->prepare("UPDATE stureg SET name = ?, mail = ?, phone = ?, class = ?, year = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $class, $year, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Student details updated successfully!'); window.location.href='Student Info.php';</script>";
    } else {
        echo "<script>alert('Failed to update student details.');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Info</title>
    <link rel="stylesheet" href="Student Info.css">
    <style>
        /* Style for the Edit button */
        button[type="submit"] {
            background-color: rgb(109, 67, 0);
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        button[type="submit"] a {
            color: white;
            text-decoration: none;
        }

        button[type="submit"]:hover {
            background-color: rgb(90, 55, 0);
        }
    </style>
</head>

<body>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

<!-- Sidebar (Same as before) -->
<nav class="sidebar">
    <div class="logo-name"></div>
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
        <p class="logo"></p>
        <img src="users.png" alt="">
    </div>
    </section>

<script src="JAVA.js"></script>

<!-- Add this CSS -->
<style>
    .sidebar .menu-items i {
        font-size: 20px; /* Bigger icon size */
      
        margin-right: 10px; /* Space between icon and text */
    }
    .sidebar .menu-items a {
        display: flex;
        align-items: center;
        font-size: 19px; /* Bigger text */
    }
</style>

<!-- Popup Edit Form -->
<?php if ($editStudent): ?>
<div id="editPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Edit Student</h2>
        <p style="text-align: center; color: gray; margin-bottom: 20px;">
            Update the details of the selected student below. Ensure all fields are filled correctly before submitting.
        </p>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $editStudent['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $editStudent['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $editStudent['mail']; ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $editStudent['phone']; ?>" required>
            <label for="class">Class:</label>
            <input type="text" name="class" id="class" value="<?php echo $editStudent['class']; ?>" required>
            <label for="year">Year:</label>
            <input type="text" name="year" id="year" value="<?php echo $editStudent['year']; ?>" required>
            <button type="submit" name="update_student" style="background-color: rgb(109,67, 0); color:white;">Update</button>
        </form>
    </div>
</div>
<?php endif; ?>

    <main class="table" id="customers_table">
        
            <h1>Studets Info</h1>
            <form method="POST">
            
        <!-- Search by Name -->
        <label for="search-name">Name:</label>
        <input type="text" name="search_name" id="search-name" style="background-color: white; color:black;">
        <button type="submit" name="search_name_btn" style="background-color: rgb(109,67, 0); color:white;">Search</button>
        <!-- Show All Records -->
        <button type="submit" name="show_all" style="background-color: rgb(109,67, 0); color:white;">Show All</button>


        <!-- Select Class Type (UG/PG) -->
        <label for="class"> Class :</label>
        <select name="class" id="class" style="background-color:white; color:black;" onchange="updateYearOptions()">
            <option value="">Select</option>
            <option value="UG">UG</option>
            <option value="PG">PG</option>
        </select>

        <!-- Year Selection -->
        <label for="year"> Year:</label>
        <select name="year" id="year" style="background-color: white; color:black;">
            <option value="" disabled selected>Select year</option>
        </select>

        <button type="submit" name="search_class_year_btn" style="background-color: rgb(109,67, 0); color:white;">Search</button>
    </form>
</div>

<script>
function updateYearOptions() {
    const classSelect = document.getElementById('class');
    const yearSelect = document.getElementById('year');
    const selectedClass = classSelect.value;

    // Clear existing options
    yearSelect.innerHTML = '<option value="" disabled selected>Select year</option>';

    if (selectedClass === 'UG') {
        yearSelect.innerHTML += '<option value=" 1st"> 1</option>';
        yearSelect.innerHTML += '<option value=" 2nd"> 2</option>';
        yearSelect.innerHTML += '<option value=" 3rd"> 3</option>';
    } else if (selectedClass === 'PG') {
        yearSelect.innerHTML += '<option value=" 1st"> 1</option>';
        yearSelect.innerHTML += '<option value=" 2nd"> 2</option>';
    }
}
</script>

                        </div>
                    </div>

        <section class="table__body">
            <table class="table" id="customers_table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>class</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['mail']; ?></td>
                            <td><?php echo $row['phone']; ?></td>
                            <td><?php echo $row['class']; ?></td>
                            <td><?php echo $row['year']; ?></td>
                            <td>
                               
                                    <button type="submit" > <a href="?edit_id=<?php echo $row['id']; ?>" onclick="openPopup()">Edit</a></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function editStudent(id) {
            // Redirect to the edit page with the student ID
            window.location.href = 'edit_student.php?id=' + id;
        }

        const search = document.querySelector('.input-group input');

        if (search) {
            console.log("Search bar found!");

            search.addEventListener('input', function() {
                let search_data = search.value.trim().toLowerCase();
                let table_rows = document.querySelectorAll('tbody tr');

                console.log("Search query:", search_data);

                table_rows.forEach((row, i) => {
                    let table_data = row.textContent.toLowerCase();
                    console.log("Row " + i + " content:", table_data);

                    let match = table_data.includes(search_data);
                    row.classList.toggle('hide', !match);
                    row.style.setProperty('--delay', i / 25 + 's');

                    console.log("Row " + i + " visibility:", match ? "Visible" : "Hidden");
                });

                document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
                    visible_row.style.backgroundColor = (i % 2 === 0) ? 'transparent' : '#0000000b';
                });
            });
        } else {
            console.log("Search bar NOT found! Check your HTML.");
        }

        // Open the popup
        function openPopup() {
            document.getElementById('editPopup').style.display = 'block';
        }

        // Close the popup
        function closePopup() {
            document.getElementById('editPopup').style.display = 'none';
        }

        // Automatically open the popup if edit_id is set
        <?php if ($editStudent): ?>
        document.addEventListener('DOMContentLoaded', function() {
            openPopup();
        });
        <?php endif; ?>
    </script>

    <style>
        /* Popup styles */
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
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .popup-content form {
            margin-left:1px;
        }

       

        .popup-content form button:hover {
            background-color: rgb(90, 55, 0);
        }

        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>
</body>

</html>