<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
    <div class="container mt-5">
        <h4>Add Product</h4>
        <form action="insert_data.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="productName" class="form-label">Product Title</label>
                    <input type="text" name="name" class="form-control" id="productName" placeholder="Enter product Title" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="productDescription" class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" id="productDescription" placeholder="Enter product Image" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="productPrice" class="form-label">Product Price</label>
                    <input type="number" name="price" class="form-control" id="productPrice" placeholder="Enter product price" required>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="productQuantity" class="form-label">Product Quantity</label>
                    <input type="number" name="qnty" class="form-control" id="productQuantity" placeholder="Enter product quantity" required>
                </div>
            </div>


            <button type="submit" name="data_submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
    
    <div class="container mt-5">
        <?php
            if(isset($_GET['insert_msg'])){
                echo "<h6>".$_GET['insert_msg']."</h6>";
            }
        ?>

        <?php
            if(isset($_GET['update_msg'])){
                echo "<h6>".$_GET['update_msg']."</h6>";
            }
        ?>
        <?php
            if(isset($_GET['delete_msg'])){
                echo "<h6>".$_GET['delete_msg']."</h6>";
            }
        ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col" style="float:right">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                 $limit = 10; // Number of items per page
                 $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                 $offset = ($page - 1) * $limit;
             
                 // Get the total number of records
                 $total_query = "SELECT COUNT(*) as total FROM `product`";
                 $total_result = mysqli_query($connection, $total_query);
                 $total_row = mysqli_fetch_assoc($total_result);
                 $total_records = $total_row['total'];
                 $total_pages = ceil($total_records / $limit);

                    $query = "select * from `product` ORDER BY `id` desc LIMIT $limit OFFSET $offset";
                    $result = mysqli_query($connection, $query);

                    if(!$result){
                        die("query failed".mysqli_error());
                    } else {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <tr>
                                    <td><img src="images/<?php echo $row['image']; ?>" alt="Product Image" style="width: 50px; height: auto;"></td>
                                    <td><?php echo $row['name'] ;?></td> 
                                    <td><?php echo $row['price'] ;?></td> 
                                    <td><?php echo $row['quantity'] ;?></td> 
                                    <td style="text-align:right;">
                                        <a href="update_product.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Update</a>
                                        <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                    </td>
                                </tr>
                            <?php
                        }
                    }
                ?>
                
                
            </tbody>
        </table>


        <nav>
    <ul class="pagination">
        <?php if($page > 1): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
            </li>
        <?php endif; ?>

        <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <?php if($page < $total_pages): ?>
            <li class="page-item">
                <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>