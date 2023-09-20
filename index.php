<?php
$host = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'database';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM students";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        a {
            display: block;
            margin: 10px;
            text-align: center;
            text-decoration: none;
            background-color: #333;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #555;
        }
    </style>
    <title>Student Attendance System</title>
</head>
<body>
    <h1>Student Attendance System</h1>
    <table>
        <tr>
            <th>Student Name</th>
            <th>Roll Number</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['roll_number']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <a href="add_student.php">Add Student</a>
    <a href="attendance.php">Mark Attendance</a>
</body>
</html>

<?php
mysqli_close($conn);
?>