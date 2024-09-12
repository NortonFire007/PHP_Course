<?php
$uploadDirectory = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

if (is_dir($uploadDirectory)) {
    $files = scandir($uploadDirectory);
    $files = array_diff($files, ['.', '..']);

    if (!empty($files)) {
        echo "<h2>Uploaded Files:</h2><ul>";
        foreach ($files as $file) {
            $fileUrl = '/uploads/' . urlencode($file);
            echo '<li><a href="' . $fileUrl . '">' . htmlspecialchars($file) . '</a></li>';
        }
        echo "</ul>";
    } else {
        echo "No files found in the uploads directory.";
    }
} else {
    echo "The upload directory does not exist.";
}
?>
