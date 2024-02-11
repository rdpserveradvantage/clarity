<?php

// Function to compress image
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    $quality = 10 ; 

    if ($info['mime'] == 'image/jpeg') 
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/png') 
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);
}

// Check if form is submitted
if (isset($_POST['submit'])) {
    // File upload path
    $targetDir = "uploads/";
    $targetFile1 = $targetDir . basename($_FILES["image1"]["name"]);
    $targetFile2 = $targetDir . basename($_FILES["image2"]["name"]);

    // Check if file is an image
    $imageFileType1 = strtolower(pathinfo($targetFile1, PATHINFO_EXTENSION));
    $imageFileType2 = strtolower(pathinfo($targetFile2, PATHINFO_EXTENSION));

    $uploadOk = 1;

    // Check if image file is a actual image or fake image
    $check1 = getimagesize($_FILES["image1"]["tmp_name"]);
    $check2 = getimagesize($_FILES["image2"]["tmp_name"]);

    if ($check1 !== false && $check2 !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file extensions
    if ($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType2 != "jpg" && $imageFileType2 != "png") {
        echo "Sorry, only JPG, JPEG, PNG files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["image1"]["tmp_name"], $targetFile1) && move_uploaded_file($_FILES["image2"]["tmp_name"], $targetFile2)) {
            // Compress images if size is more than 2MB
            if ($_FILES["image1"]["size"] > 2000000) {
                $compressedImage1 = $targetDir . "compressed_" . basename($_FILES["image1"]["name"]);
                compressImage($targetFile1, $compressedImage1, 50); // Adjust compression quality as needed
                unlink($targetFile1); // Remove original file
                $targetFile1 = $compressedImage1;
            }

            if ($_FILES["image2"]["size"] > 2000000) {
                $compressedImage2 = $targetDir . "compressed_" . basename($_FILES["image2"]["name"]);
                compressImage($targetFile2, $compressedImage2, 50); // Adjust compression quality as needed
                unlink($targetFile2); // Remove original file
                $targetFile2 = $compressedImage2;
            }

            echo "The files have been uploaded successfully.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>
