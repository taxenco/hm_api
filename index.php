<?php

include 'helper.php';

$helper = new Helper;

if (isset($_POST['submit'])) {
 $handle = fopen($_FILES['filename']['tmp_name'], "r");
 $headers = fgetcsv($handle, 1000, ",");
 $arr = array();
 while (($data = fgetcsv($handle, 1000, ",")) !== false) {
 array_push($arr,$data);
}
fclose($handle);
$output = $helper->transform($arr);
}
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Housemates</title>
        <!-- CSS -->
        <meta charset="utf-8">
        <link rel="stylesheet" href="./index.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>

    <body>
        <div class='container'>
            <div id='form'>
                <form enctype='multipart/form-data' action='#' method='post'>
                    <input size='50' type='file' name='filename' required='required'>
                    <input id="inputForm" type='submit' name='submit' value='Upload file'>
                </form>
            </div>
            <?php 
			if(isset($output)){
                echo "<pre>".json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES). "</pre>";
			}
			?>

        </div>
    </body>

</html>