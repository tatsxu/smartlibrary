<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $studentId = $_POST['student_id'] ?? '';
    $studentName = $_POST['student_name'] ?? '';
    $course = $_POST['course'] ?? '';
    $year = $_POST['year'] ?? '';
    $room = $_POST['room'] ?? '';
    $date = $_POST['date'] ?? null;
    $time = $_POST['time'] ?? '';

    if ($studentId === '' || $studentName === '' || $room === '') {
        echo "Required fields missing.";
        exit;
    }

    $stmt = $conn->prepare("
        INSERT INTO rooms (student_id, student_name, course, year, room, date, time, issue_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param("sssssss",
        $studentId,
        $studentName,
        $course,
        $year,
        $room,
        $date,
        $time
    );

    if ($stmt->execute()) {
        header("Location: confirmationR.html");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
