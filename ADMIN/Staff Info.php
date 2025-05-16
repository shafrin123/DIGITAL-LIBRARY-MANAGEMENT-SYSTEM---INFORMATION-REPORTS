<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT * FROM staff ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Search by exact name
if (isset($_POST['search_name_btn'])) {
    $search_name = isset($_POST['search_name']) ? trim($_POST['search_name']) : '';
    if (!empty($search_name)) {
        $stmt = $conn->prepare("SELECT * FROM staff WHERE name = ?");
        $stmt->bind_param("s", $search_name);
        $stmt->execute();
        $result = $stmt->get_result();
    }
}
if (isset($_POST['show_all'])) {
    $stmt = $conn->prepare("SELECT * FROM staff");
    $stmt->execute();
    $result = $stmt->get_result();
}

// Fetch staff details for editing if an ID is provided
$editStaff = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $conn->prepare("SELECT * FROM staff WHERE id = ?");
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $editStaff = $stmt->get_result()->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Info</title>
    <link rel="stylesheet" href="Staff Info.css">
</head>

<body>
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

<!-- Sidebar -->
<nav class="sidebar">
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
</nav>

<section class="dashboard">
    <h1>Staff Info</h1>
    <!-- Success message element -->
    <div id="updateSuccess" style="display: none; color: green; margin-bottom: 10px;">Record updated successfully!</div>
    <form method="POST">
        <label for="search-name">Name:</label>
        <input type="text" name="search_name" id="search-name" style="background-color: white; color:black;">
        <button type="submit" name="search_name_btn" style="background-color: rgb(109,67, 0); color:white;">Search</button>
        <!-- Show All Records -->
        <button type="submit" name="show_all" style="background-color: rgb(109,67, 0); color:white;">Show All</button>
          <!-- Department Selection -->
          <label for="department">Department:</label>
        <select name="department" id="department" style="background-color:white; color:black;">
            <option value="">Select Department</option>
            <option value="Computer Science">Computer Science</option>
            <option value="Mathematics">Mathematics</option>
            <option value="Physics">Physics</option>
            <option value="Biology">Biology</option>
            <option value="English">English</option>
        </select>
        <button type="submit" name="search_class_year_btn" style="background-color: rgb(109,67, 0); color:white;">Search by Department</button>

    </form>
</section>

<!-- Popup Edit Form -->
<?php if ($editStaff): ?>
<div id="editPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2>Edit Staff</h2>
         <p style="text-align: center; color: gray; margin-bottom: 20px;">
            Update the details of the selected staff below. Ensure all fields are filled correctly before submitting.
        </p>
        <form id="editForm" method="POST" action="UpdateStaff.php">
            <input type="hidden" name="id" value="<?php echo $editStaff['id']; ?>">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $editStaff['name']; ?>" required>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo $editStaff['email']; ?>" required>
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" value="<?php echo $editStaff['phone']; ?>" required>
            <label for="department">Department:</label>
            <input type="text" name="department" id="department" value="<?php echo $editStaff['department']; ?>" required>
            <button type="submit" style="background-color: rgb(109,67, 0); color:white;">Update</button>
        </form>
    </div>
</div>
<?php endif; ?>

<main class="table">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['department']; ?></td>
                    <td>
                        <a href="?edit_id=<?php echo $row['id']; ?>" onclick="openPopup()" >Edit</a>
                        
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<script>
    // Open the popup
    function openPopup() {
        document.getElementById('editPopup').style.display = 'block';
    }

    // Close the popup
    function closePopup() {
        document.getElementById('editPopup').style.display = 'none';
    }

    // Automatically open the popup if edit_id is set
    <?php if ($editStaff): ?>
    document.addEventListener('DOMContentLoaded', function() {
        openPopup();
    });
    <?php endif; ?>

    // Intercept form submit on popup via AJAX
    const editForm = document.getElementById("editForm");
    if (editForm) {
        editForm.addEventListener("submit", function(e) {
            e.preventDefault();
            const formData = new FormData(editForm);
            fetch(editForm.action, {
                method: "POST",
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Display success message and close popup:
                const successDiv = document.getElementById("updateSuccess");
                successDiv.style.display = "block";
                successDiv.textContent = data;
                closePopup();
                // Optionally refresh page after 2 seconds for updated data:
                setTimeout(() => { location.reload(); }, 2000);
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    }
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
