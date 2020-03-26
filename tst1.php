<?php
$fileName = "thisisatestthisisatestthisisatestthisis.jpeg";
echo $fileName . "<BR>";

// if the filename is longer than 60 chars shorten it
if (($len = strlen($fileName)) > 60) {
    // get number of characters in excess of filename limit
    $excess = $len - 60;
    
    // get filename without extension, get substring equal in len
    $fileNoExt = pathinfo($fileName, PATHINFO_FILENAME);
    $fileNoExt = substr($fileNoExt, 0, (strlen($fileNoExt)-$excess));

    // concatenate filename and extension
    $fileName = $fileNoExt . "." . pathinfo($fileName, PATHINFO_EXTENSION);
}

echo strlen($fileName);
?>