<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT student_name, book_name AS book_title, due_date, return_date, fine_amount 
        FROM book_issues
        WHERE fine_amount > 0";
$result = mysqli_query($conn, $sql);

echo "<h3>📢 Overdue Books & Fines</h3>";
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Student Name</th>
                <th>Book Title</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Fine Amount</th>
            </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>{$row['student_name']}</td>
                <td>{$row['book_title']}</td>
                <td>{$row['due_date']}</td>
                <td>{$row['return_date']}</td>
                <td style='color:red;'>₹{$row['fine_amount']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No overdue books.</p>";
}

mysqli_close($conn);
?>