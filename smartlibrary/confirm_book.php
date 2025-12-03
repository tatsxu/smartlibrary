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
$bookTitle   = $_POST['book_title'] ?? '';
$dateBorrow  = $_POST['date_borrowed'] ?? null;

if ($studentId === '' || $studentName === '' || $bookTitle === '') {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$stmt = $conn->prepare("
    INSERT INTO books (student_id, student_name, course, year, book_title, date_borrowed, created_at)
    VALUES (?, ?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param("ssssss",
    $studentId,
    $studentName,
    $course,
    $year,
    $bookTitle,
    $dateBorrow
);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
