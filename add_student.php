<?php
$host = 'localhost:3307';
$username = 'root';
$password = '';
$database = 'database';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rollNumber = $_POST['roll_number'];

    // Note: We no longer need to specify the 'id' column in the INSERT statement.
    $insertQuery = "INSERT INTO students (name, roll_number) VALUES ('$name', '$rollNumber')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        label {
            font-weight: bold;
        }

        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        a {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Add Student</h1>
    <form method="POST">
        <label for="name">Student Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="roll_number">Roll Number:</label>
        <input type="text" name="roll_number" id="roll_number" required><br>

        <input type="submit" value="Add Student">
    </form>
    <a href="index.php">Back to Student List</a>
</body>
</html>