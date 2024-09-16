<?php
if (!isset($_GET['src'])) {
    echo "No template source provided.";
    exit();
}
$templateSrc = urldecode($_GET['src']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desktop View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <iframe src="<?php echo htmlspecialchars($templateSrc); ?>" style="width: 100%; height: 100vh; border: none;"></iframe>
</body>
</html>