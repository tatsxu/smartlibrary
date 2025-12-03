<?php
header("Content-Type: application/json");
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

$studentId   = $_POST['student_id'] ?? '';
$studentName = $_POST['student_name'] ?? '';
$course      = $_POST['course'] ?? '';
$year        = $_POST['year'] ?? '';
$room        = $_POST['room'] ?? '';
$date        = $_POST['date'] ?? '';
$time        = $_POST['time'] ?? '';
$issueDate   = $_POST['issue_date'] ?? date("Y-m-d");

if ($studentId === '' || $studentName === '' || $room === '') {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO rooms (student_id, student_name, course, year, room, date, time, issue_date)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("ssssssss",
    $studentId,
    $studentName,
    $course,
    $year,
    $room,
    $date,
    $time,
    $issueDate
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
