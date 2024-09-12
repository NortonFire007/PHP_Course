<?php
$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0755, true);
    echo "The directory '$uploadDirectory' was created successfully.<br>";
} else {
    echo "The directory '$uploadDirectory' already exists.<br>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['fileToUpload']) && is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
        $fileName = basename($_FILES['fileToUpload']['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileSize = $_FILES['fileToUpload']['size'];

        if (in_array($fileType, ['jpg', 'jpeg', 'png']) && $fileSize <= 2 * 1024 * 1024) {
            $targetFile = $uploadDirectory . $fileName;

            if (file_exists($targetFile)) {

                $fileName = pathinfo($fileName, PATHINFO_FILENAME) . '_' . time() . '.' . $fileType;
                $targetFile = $uploadDirectory . $fileName;
            }

            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $targetFile)) {
                echo "File uploaded successfully!<br>";
                echo "File Name: " . htmlspecialchars($fileName) . "<br>";
                echo "File Type: " . htmlspecialchars($fileType) . "<br>";
                echo "File Size: " . round($fileSize / 1024, 2) . " KB<br>";
                echo '<a href="/uploads/' . urlencode($fileName) . '">Download File</a>';
            } else {
                echo "Error in uploading file.";
            }
        } else {
            echo "Only JPG, JPEG, and PNG files are allowed, and the file size must be less than 2 MB.";
        }
    } else {
        echo "No file uploaded.";
    }
}
?>
