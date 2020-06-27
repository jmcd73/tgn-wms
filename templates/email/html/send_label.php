<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Pallet Print</h1>
    <p><?= h($itemCode); ?></p>
    <p><?= h($reference); ?></p>
    <p><?= h($batch); ?></p>
    <p><?= h($jobId); ?></p>
    
<?php $content = explode("\n", $content);
    foreach ($content as $line) :
        echo '<p> ' . $line . "</p>\n";
    endforeach; ?>

</body>
</html>