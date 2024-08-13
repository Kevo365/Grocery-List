<?php
    include 'dbcon.php';

    if(isset($_POST['data_submit'])) {
        
        $title = $_POST['name'];
        $price = $_POST['price'];
        $qnty = $_POST['qnty'];

        // Handling the image upload
        $target_dir = "images/";
        $target_file =  $target_dir .basename($_FILES["image"]["name"]);
        $target_file_insert =  basename($_FILES["image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if file already exists
        // if (file_exists($target_file)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Check file size (5MB maximum)
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // Try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Insert data into the database
                $query = "INSERT INTO `product` (`name`, `image`, `price`, `quantity`) VALUES ('$title', '$target_file_insert', '$price', '$qnty')";
                $result = mysqli_query($connection, $query);

                if(!$result){
                    die("Query Failed: " . mysqli_error($connection));
                } else {
                    header('location:index.php?insert_msg=Product Added Successfully.');
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
?>
