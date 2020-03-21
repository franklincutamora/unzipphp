<?php
function printPhpVersion() {
    return nl2br('Current PHP version: ' . phpversion() . "\n");
}

function detectZipFiles() {
    // create a handler to read the directory contents
    $handler = opendir(".");
    $found = false;

    echo "Choose file to unzip: <br>";
    echo '<form action="" method="post">';
 
    while ($file = readdir($handler)) {
        if (preg_match ("/.zip$/i", $file)) {
            echo '<input type="radio" name="file" value=' . $file . '> ' . $file . '<br>';
            $found = true;
        }
    }
    closedir($handler);

    if ($found === false) { echo "No .zip file found.<br>"; }
    echo '<br>Warning: Existing files will be overwritten.<br><br><input type="submit" value="Unzip!"></form>';
}

function unzip($file){
    // Get Project path
    define('_PATH', dirname(__FILE__));

    $zip = new ZipArchive;
    $res = $zip->open($file);
    if ($res === TRUE) {
        $path = _PATH;

        // Extract file
        $zip->extractTo($path);
        $zip->close();
        chmod($path, 0755);

        echo '<script>alert("'.$file.' is successfully extracted!")</script>';
    } else {
        echo '<script>alert("Unzipping failedl!")</script>';
    }
}

function main(){
    echo printPhpVersion();
    detectZipFiles();
    if (isset($_POST['file'])) {
        unzip($_POST['file']);
        if ($handle = opendir('.')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    echo nl2br("$entry\n");
                }
            }
            closedir($handle);
        }
    }
    unset($_POST['file']);
}

main();
