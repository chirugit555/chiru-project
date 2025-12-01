
<?php
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

$errors = [];
$name    = trim($_POST['cname'] ?? '');
$email   = trim($_POST['cemail'] ?? '');
$subject = trim($_POST['csubject'] ?? '');
$message = trim($_POST['cmessage'] ?? '');

if ($name === '') {
    $errors[] = 'Name is required.';
}
if (!is_valid_email($email)) {
    $errors[] = 'A valid email is required.';
}
if ($message === '') {
    $errors[] = 'Message is required.';
}

if (empty($errors)) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages
            (full_name, email, subject, message)
            VALUES (:name, :email, :subject, :message)
        ");

        $stmt->execute([
            ':name'    => $name,
            ':email'   => $email,
            ':subject' => $subject,
            ':message' => $message,
        ]);

        $successMessage = "Thank you, {$name}! Your message has been received.";
    } catch (PDOException $e) {
        $errors[] = 'An error occurred while sending your message.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Status | Adopt-A-Pals</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1>Adopt-A-Pals</h1>
</header>
<main>
    <div class="container">
        <h2>Contact Status</h2>

        <?php if (!empty($errors)): ?>
            <div class="message message-error">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= e($err); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="message message-success">
                <?= e($successMessage ?? 'Message sent.'); ?>
            </div>
        <?php endif; ?>

        <p><a href="index.php#contact">Back to Contact Page</a></p>
    </div>
</main>
<footer>
    &copy; <?= date('Y'); ?> Adopt-A-Pals
</footer>
</body>
</html>
