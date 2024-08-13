<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background: #f0f8ff
    }

    .container {
        /* border:4px solid red; */
        padding: 20px;
        background: #faf9f6;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }
    h6{
        color:green;
    }
    </style>
</head>

<body>
    <?php include('dbcon.php'); ?>

    <?php

        if(isset($_GET['id'])){
            $id = $_GET['id'];
        

            $query = "select * from `product` where `id` = '$id'";
            $result = mysqli_query($connection, $query);
            if(!$result)
            {
                die("query failed".mysqli_error());
            } else {
                $row = mysqli_fetch_assoc($result);
                // print_r($row);
            }
        }
       
    ?>

<?php
    // include 'dbcon.php';

    if(isset($_POST['update_data'])) {

        if(isset($_GET['id_new'])) {
            $id_new = $_GET['id_new'];
        }
        
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['qnty'];
        
        // Handling image upload
        if(!empty($_FILES['image']['name'])) {
            $target_dir = "images/";
            $target_file = $target_dir .basename($_FILES["image"]["name"]);
            $target_file_insert = basename($_FILES["image"]["name"]);
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

            if ($uploadOk == 1) {
                // Try to upload file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Update the query with the new image
                    $query = "UPDATE `product` SET `name` = '$name', `image` = '$target_file_insert', `price` = '$price', `quantity` = '$quantity' WHERE `id` = '$id_new'";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $query = "UPDATE `product` SET `name` = '$name', `price` = '$price', `quantity` = '$quantity' WHERE `id` = '$id_new'";
            }
        } else {
            // If no new image is uploaded, don't update the image field
            $query = "UPDATE `product` SET `name` = '$name', `price` = '$price', `quantity` = '$quantity' WHERE `id` = '$id_new'";
        }

        $result = mysqli_query($connection, $query);

        if(!$result) {
            die("Query failed: " . mysqli_error($connection));
        } else {
            header('Location: index.php?update_msg=Product Updated Successfully.');
        }
    }
?>

    <div class="container mt-5">
        <h4>Update Product</h4>
        <form action="update_product.php?id_new=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="productName" class="form-label">Product Title</label>
                    <input type="text" value="<?php echo $row['name']?>" name="name" class="form-control" id="productName" placeholder="Enter product Title" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="productDescription" class="form-label">Change Image</label>
                    <input type="file"  name="image"  class="form-control" id="productDescription" placeholder="Enter product Image" >
                </div>
                <img src="images/<?php echo $row['image']; ?>" alt="Product Image" 
                    style="width: 150px; height: auto;">

                <div class="mb-3 col-md-6">
                    <label for="productPrice" class="form-label">Product Price</label>
                    <input type="number" value="<?php echo $row['price']?>" name="price" class="form-control" id="productPrice" placeholder="Enter product price" required>
                </div>
                <div class="mb-3 col-md-4">
                    <label for="productQuantity" class="form-label">Product Quantity</label>
                    <input type="number" value="<?php echo $row['quantity']?>" name="qnty" class="form-control" id="productQuantity" placeholder="Enter product quantity" required>
                </div>
            </div>


            <button type="submit" name="update_data" class="btn btn-primary">Update Product</button>
        </form>
    </div>
    
    

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>