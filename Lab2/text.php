<?php
$logFile = 'log.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $textToWrite = htmlspecialchars($_POST['textToWrite']);
    
    file_put_contents($logFile, $textToWrite . PHP_EOL, FILE_APPEND);
    echo "Text written to file successfully!<br>";
}

if (file_exists($logFile)) {
    echo "<h2>Contents of log.txt</h2>";
    echo nl2br(file_get_contents($logFile));
} else {
    echo "The file log.txt does not exist.";
}
?>