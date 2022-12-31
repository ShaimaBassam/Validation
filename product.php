<?php
include('connect.php');
?>

<?php
// session_start();

// $admin_id = $_SESSION['admin_id'];
// if(!isset($admin_id)){
// header('location:admin_login.php');
// };

//   DELETE PRODUCTS

if(isset($_GET['delete'])){
$delete_id = $_GET['delete'];
$delete_product_image = $db->prepare("SELECT * FROM `products` WHERE id = ?");
$delete_product_image->execute([$delete_id]);
$fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);

unlink('./upload_img'.$fetch_delete_image['image']);
$delete_product = $db->prepare("DELETE FROM `products` WHERE id = ?");
$delete_product->execute([$delete_id]);
header('location:product.php');
}
?>


<!-- PRODUCTS TABLE -->

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  
</head>
<body class="hold-transition sidebar-mini">


<div class="wrapper">


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content  show-products">
      <div class="container-fluid">
      <?php
      $select_products = $db->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
      while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ }
      }
   ?>
   <div class="box">
      <?php
      $select_product_category = $db->prepare("SELECT * 
      FROM `products`
      INNER JOIN `categories` ON products.category_id = categories.category_id;");
      $select_product_category->execute();
      if($select_product_category->rowCount() > 0){
       while($fetch_product_category = $select_product_category->fetch(PDO::FETCH_ASSOC)){}
      }
         ?>
        <!-- /.row -->
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Products Table</h3>
              </div>
              <!-- ./card-header -->
              <div class="card-body">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Product Name</th>
                      <th>Product Category</th>
                      <th>Product Price</th>
                      <th>Product Description</th>
                      <th>Product Image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                  $select_products = $db->prepare("SELECT * FROM `products`");
                  $select_products->execute();
                  if($select_products->rowCount() > 0 ){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
                    $s=0;
                      ?> 
                    <tr data-widget="expandable-table" aria-expanded="false">
                    
                      <td><?= $fetch_products['id']; ?></td>
                      <td class="product_name"><?= $fetch_products['product_name']; ?> </td>
                      <td>
                        <?php 
                        $select_product_category = $db->prepare("SELECT * 
                        FROM `products`
                        INNER JOIN `categories` ON products.category_id = categories.category_id;");
                        $select_product_category->execute();
                        if($select_product_category->rowCount() > 0 ){
                          while($fetch_product_category = $select_product_category->fetch(PDO::FETCH_ASSOC)){
                            if( $fetch_products['category_id'] == $fetch_product_category['category_id'] && $s == 0 )
                            { 
                              $s++;
                              echo   $fetch_product_category['name'];
                            }
                            
                          }
                      }
                        ?>
                      </td>
                      <td class="price">$ <?= $fetch_products['price'];?></td>
                      <td class="product_desc"><?= $fetch_products['product_desc'];?></td>
                      <td>
                        <img src="../upload_img/<?= $fetch_products['image']; ?>" width="150px" height="150px">
                        </td>

                      <td>
                        <button class="btn btn-success mt-2"><a href="updateproduct.php" class="option-btn text-decoration-none text-light">Update</a></button>
                        <button class="btn btn-danger mt-2"><a href="product.php?delete=<?= $fetch_products['id'];?>" class="delete-btn text-light text-decoration-none" onclick="return confirm('delete this product?');" >Delete</a></button>
                      </td>
                    </tr>
                    <?php
                    }}
                      ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>