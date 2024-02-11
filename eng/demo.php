<?
ini_set('max_file_uploads', '100'); 

phpinfo();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload Form</title>
</head>
<body>
    <h2>Upload Images</h2>
    <form action="process_demo.php" method="post" enctype="multipart/form-data">
        <label for="image1">Image 1:</label>
        <input type="file" name="image1" id="image1" accept="image/*" required>
        <br>
        <label for="image2">Image 2:</label>
        <input type="file" name="image2" id="image2" accept="image/*" required>
        <br>
        <button type="submit" name="submit">Upload</button>
    </form>
</body>
</html>
