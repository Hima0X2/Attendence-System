<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "database";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<html>
<head>
    <title>Attendance Report</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form method="post" action="">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <input type="submit" name="generate_report" value="Generate Report">
    </form>

    <h2>Attendance Report</h2>
    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Total Present Days</th>
            <th>Total Days</th>
            <th>Attendance Percentage</th>
        </tr>
        <?php
        if (isset($_POST['generate_report'])) {
            $startDate = new DateTime($_POST['start_date']);
            $endDate = new DateTime($_POST['end_date']);

            $totalDays = 0;
            // Loop through each day in the date range
            while ($startDate <= $endDate) {
                // Check if the current day is not Saturday (6) or Sunday (7)
                if ($startDate->format('N') != 6 && $startDate->format('N') != 7) {
                    $totalDays++;
                }
                $startDate->modify('+1 day'); // Move to the next day
            }

            // Reset the start date after the loop
            $startDate = new DateTime($_POST['start_date']);
        
            // Format dates as strings
            $startDateStr = $startDate->format('Y-m-d');
            $endDateStr = $endDate->format('Y-m-d');

        
            $sql = "SELECT students.roll_number AS student_id, 
            COUNT(DISTINCT attendance.class_date) AS total_present_days
    FROM students
    LEFT JOIN attendance ON students.id = attendance.student_serial
    WHERE attendance.class_date BETWEEN '$startDateStr' AND '$endDateStr'
    GROUP BY students.id";
        
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $row["attendance_percentage"] = ($row["total_present_days"] / $totalDays) * 100;
                    echo "<tr>";
                    echo "<td>" . $row["student_id"] . "</td>";
                    echo "<td>" . $row["total_present_days"] . "</td>";
                    echo "<td>" . $totalDays . "</td>";
                    echo "<td>" . $row["attendance_percentage"] . "%" . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "No attendance data available for the selected date.";
            }
        }
        ?>
    </table>
</body>
</html>
