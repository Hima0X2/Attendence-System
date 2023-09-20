<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $classDate = $_POST["date"];
    $timestamp = strtotime($classDate);

    // Get the day of the week as a string
    $dayOfWeek = date("l", $timestamp);

    if ($dayOfWeek != "Friday" && $dayOfWeek != "Saturday") {
        if (isset($_POST["attendance"])) {
            foreach ($_POST["attendance"] as $studentId) { // Change to $studentId
                $validateSql = "SELECT * FROM students WHERE id = '$studentId'"; // Change to students table
                $validateResult = $conn->query($validateSql);

                if ($validateResult !== false && $validateResult->num_rows > 0) {
                    $sql = "INSERT INTO attendance (student_serial, class_date, is_present) VALUES ('$studentId', '$classDate', 1)";

                    // Check if the query was executed successfully
                    if ($conn->query($sql) !== TRUE) {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error in validation query: " . $conn->error;
                }
            }
            echo "<script> alert('Attendance records have been saved')</script>";
        } else {
            echo "<script>alert('No attendance data submitted')</script>";
        }
    } else {
        echo "<script> alert('Cannot input data on Friday or Saturday')</script>";
    }
}

?>

<!DOCTYPE html>
<head>
    <title>Student Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
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

        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        input[type="submit"] {
            background-color: orange;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        a.report-link {
            background-color: green;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            font-size: small;
        }

        a.report-link:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>IIT 3rd Batch <br>Student Attendance System</h2>
        <p>Select a specific date for saving student's attendance</p>
    </div>
    <form method="post" action="">
        <label>Date:</label>
        <input type="date" name="date" required><br><br>

        <table>
            <tr>
                <th>Student ID</th>
                <th>Student Name</th>
                <th>Present</th>
            </tr>
            <?php
            $sql = "SELECT * FROM students"; // Change to students table
            $result = $conn->query($sql);

            if ($result !== false && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $studentId = $row["id"];
                    $studentName = $row["name"];
           ?>
            
                   <tr>
                            <td><?php echo "$studentId"; ?></td>
                            <td><?php echo "$studentName"; ?></td>
                            <td><input type='checkbox' name='attendance[]' value='<?php echo $studentId; ?>'></td> <!-- Change to $studentId -->
                    </tr>
               <?php }
             } else {
                echo "No students found in the database.";
            }
            ?>
        </table>
        <br><br>
        <div style="display: flex;justify-content: space-between;">
            <input style="background-color: orange;padding: 10px; border: 0; cursor:pointer;" type="submit" name="submit" value="Submit">
            <a href="report.php" style="background-color: green;padding: 10px; border: 0; cursor:pointer;text-decoration:none; color:black; font:small" >Show Report</a>
        </div>
    </form>
    <br>

    <?php 
    $conn->close();
    ?>
</body>
</html>
