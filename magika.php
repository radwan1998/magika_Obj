<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /");
    exit;
}

// Include the FileChecker class
require_once 'FileChecker.php';

// Check if a file has been uploaded
if (!isset($_FILES["fileToUpload"]) || $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_NO_FILE) {
    echo "<div class='error'>No file has been selected for upload.</div>";
    exit;
}

$allowedMaxFileSize = 15; // Maximum allowed file size in MB

// Create an instance of FileChecker
$fileChecker = new FileChecker($_FILES["fileToUpload"]["name"], $_FILES["fileToUpload"]["size"], $_FILES["fileToUpload"]["tmp_name"], $allowedMaxFileSize);

// Call executeCommand method
$fileChecker->executeCommand();


echo $fileChecker->getFileGroupInfo();



?>
