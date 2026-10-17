<?php
/**
 * Simple PHP path checker to help diagnose 404 errors
 */

echo "<h1>PHP Path Checker</h1>";

// Show current file location
echo "<h2>Current File</h2>";
echo "<p>This file is located at: <strong>" . __FILE__ . "</strong></p>";
echo "<p>Real path: <strong>" . realpath(__FILE__) . "</strong></p>";

// Show parent directory
$parentDir = dirname(__FILE__);
echo "<h2>Parent Directory</h2>";
echo "<p>Parent directory is: <strong>" . $parentDir . "</strong></p>";
echo "<p>Real path: <strong>" . realpath($parentDir) . "</strong></p>";

// Check for important files
$filesToCheck = [
    'index.php',
    'cron-setup.php',
    'public/index.php',
    'public/cron-setup.php',
];

echo "<h2>File Existence Check</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>File</th><th>Full Path</th><th>Exists</th></tr>";

foreach ($filesToCheck as $file) {
    $fullPath = $parentDir . '/' . $file;
    $exists = file_exists($fullPath) ? "Yes" : "No";
    $color = $exists == "Yes" ? "green" : "red";
    echo "<tr><td>{$file}</td><td>{$fullPath}</td><td style='color:{$color};'><strong>{$exists}</strong></td></tr>";
}
echo "</table>";

// List directory contents
echo "<h2>Directory Contents (algo folder)</h2>";
$contents = scandir($parentDir);
echo "<ul>";
foreach ($contents as $item) {
    if ($item != "." && $item != "..") {
        $isDir = is_dir($parentDir . "/" . $item) ? " (directory)" : "";
        echo "<li>{$item}{$isDir}</li>";
    }
}
echo "</ul>";

// List public directory contents if it exists
$publicDir = $parentDir . "/public";
if (is_dir($publicDir)) {
    echo "<h2>Public Directory Contents</h2>";
    $publicContents = scandir($publicDir);
    echo "<ul>";
    foreach ($publicContents as $item) {
        if ($item != "." && $item != "..") {
            $isDir = is_dir($publicDir . "/" . $item) ? " (directory)" : "";
            echo "<li>{$item}{$isDir}</li>";
        }
    }
    echo "</ul>";
}

// Server information
echo "<h2>Server Information</h2>";
echo "<p>Document Root: <strong>" . $_SERVER['DOCUMENT_ROOT'] . "</strong></p>";
echo "<p>Script Filename: <strong>" . $_SERVER['SCRIPT_FILENAME'] . "</strong></p>";
echo "<p>Request URI: <strong>" . $_SERVER['REQUEST_URI'] . "</strong></p>";
echo "<p>HTTP Host: <strong>" . $_SERVER['HTTP_HOST'] . "</strong></p>";

// Suggested URLs
echo "<h2>Try These URLs</h2>";
$host = $_SERVER['HTTP_HOST'];
echo "<ul>";
echo "<li><a href='http://{$host}/algo/cron-setup.php'>http://{$host}/algo/cron-setup.php</a></li>";
echo "<li><a href='http://{$host}/algo/public/cron-setup.php'>http://{$host}/algo/public/cron-setup.php</a></li>";
echo "<li><a href='http://{$host}/cron-setup.php'>http://{$host}/cron-setup.php</a> (if in document root)</li>";
echo "</ul>";
?>
