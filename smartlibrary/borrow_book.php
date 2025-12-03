<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $studentId   = $_POST['student_id'] ?? '';
    $studentName = $_POST['student_name'] ?? '';
    $course      = $_POST['course'] ?? '';
    $year        = $_POST['year'] ?? '';
    $bookTitle   = $_POST['book_title'] ?? '';
    $dateBorrow  = $_POST['date_borrowed'] ?? null;

    if ($studentId === '' || $studentName === '' || $bookTitle === '') {
        echo "Missing required fields.";
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
        header("Location: confirmationB.html");
        exit;
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
