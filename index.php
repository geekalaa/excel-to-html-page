<!DOCTYPE html>
<html lang="en">
<?php
ini_set('session.cache_limiter', 'nocache');
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        background-color: #f5f5f5;
        height: 100%;
    }

    div {
        width: 100%;
        display: flex;
    }

    a {
        padding: 0.5rem;
        background: lightgrey;
        border-radius: 6px;
        text-decoration: none;
        margin: 1rem;
    }

    a:hover {
        background: #42424270;
    }
    </style>
</head>

<body>
    <center style="margin-top: 32px;"><a href="generate.php">GENERATE FILES !</a>
        <center>
            <div>


                <?php    
    
function displayFolders($dir) {
    clearstatcache();
    $files = scandir($dir);
    // sort by creation time ASC to get the latest file first 
    sort($files);
    foreach($files as $file) {
        if($file != '.' && $file != '..') {
            echo '<a href="' . $dir . '/' . $file . '">' . $file . '</a>';
        }
    }
}
clearstatcache();
displayFolders('data-web');
?>
            </div>
</body>

</html>