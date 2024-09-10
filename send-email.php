<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $firstName = htmlspecialchars($_POST['first-name']);
    $lastName = htmlspecialchars($_POST['last-name']);
    $email = htmlspecialchars($_POST['email']);
    $feedbackType = htmlspecialchars($_POST['feedback-type']);
    $feedback = htmlspecialchars($_POST['feedback']);

    // Handle file upload
    if (isset($_FILES['product-pictures']) && $_FILES['product-pictures']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['product-pictures']['tmp_name'];
        $fileName = $_FILES['product-pictures']['name'];
        $destination = './uploads/' . $fileName;
        move_uploaded_file($fileTmpPath, $destination);
    }

    // Prepare the email
    $to = 'jenningsaustin74@gmail.com'; // Your email
    $subject = 'New Product Request Form Submission';
    $message = "First Name: $firstName\nLast Name: $lastName\nEmail: $email\nFeedback Type: $feedbackType\nFeedback: $feedback\n";

    if (isset($fileName)) {
        $message .= "Product Image Uploaded: $fileName";
    }

    $headers = "From: $email";

    // Send the email
    if (mail($to, $subject, $message, $headers)) {
        echo 'Email sent successfully!';
    } else {
        echo 'Failed to send email.';
    }
}
?>
