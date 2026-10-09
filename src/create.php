<?php
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = trim($_POST['student_number'] ?? '');
    $first_name     = trim($_POST['first_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $course         = trim($_POST['course'] ?? '');

    if ($student_number === '' || $first_name === '' || $last_name === '' || $course === '') {
        $error = 'All fields are required.';
    } else {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO students (student_number, first_name, last_name, course)
                 VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$student_number, $first_name, $last_name, $course]);
            header('Location: index.php');
            exit;
        } catch (PDOException $e) {
            $error = 'Could not save. The student number may already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
<h1>Add Student</h1>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <p>Student Number: <input name="student_number" required></p>
    <p>First Name: <input name="first_name" required></p>
    <p>Last Name: <input name="last_name" required></p>
    <p>Course: <input name="course" required></p>
    <button type="submit">Save Student</button>
</form>

<p><a href="index.php">Back to Student List</a></p>
</body>
</html>