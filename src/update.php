<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id             = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$student_number = trim($_POST['student_number'] ?? '');
$first_name     = trim($_POST['first_name'] ?? '');
$last_name      = trim($_POST['last_name'] ?? '');
$course         = trim($_POST['course'] ?? '');

if (!$id || $student_number === '' || $first_name === '' || $last_name === '' || $course === '') {
    exit('All fields are required.');
}

$stmt = $pdo->prepare(
    'UPDATE students
     SET student_number = ?, first_name = ?, last_name = ?, course = ?
     WHERE id = ?'
);
$stmt->execute([$student_number, $first_name, $last_name, $course, $id]);

header('Location: index.php');
exit;