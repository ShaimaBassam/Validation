<?php 
include('connect.php');
?>
<?php
if(isset($_POST['add_product'])){
$name = $_POST['product_name'];
$price = $_POST['price'];
$details = $_POST['product_desc'];
$category_name = $_POST['category'];

$image = $_FILES['image']['name'];
$image_size_01 = $_FILES['image']['size'];
$image_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = '../uploaded_img/'.$image;

$select_products = $db->prepare("SELECT * FROM `products` WHERE id = ?");
$select_products->execute([$id]);

if($insert_products){
    if($image_size > 2000000){
       $message[] = 'image size is too large!';
    }else{
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'Product edited!';
    }
 }

if($select_products->rowCount() > 0){
    $message[] = 'product name already exist!';
}else{
 
    $query = 'UPDATE products SET product_name = :product_name, price = :price , product_desc = :product_desc, image = :image, category = :category  WHERE id= :id' ;
    $statement=$db->prepare($query);
    $statement->bindValue(':product_name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':product_desc', $details);
    $statement->bindValue(':image', $image);
    $statement->bindValue(':category', $category_name);
    $statement->execute();
    header("Location:localhost/PHP_PROJECT/admindashboard/product.php/");
    };


}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Product</title>

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
              <li class="breadcrumb-item active">Edit Product Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content" name="add_product">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="product_name">
                  </div>
                  <div class="form-group">
                    <label>Product Price</label>
                    <input type="text" class="form-control" name="price">
                  </div>
                  <div class="form-group">
                    <label>Product Description</label>
                    <input type="text" class="form-control" name="product_desc">
                  </div>

                  <div class="inputBox">

            <span>product category </span>

            <select name="category" placeholder="choose product category" required maxlength="500" cols="60" rows="10">
               <?php
                     $prepare_category = $db->prepare("SELECT * FROM `categories`");
                     $prepare_category->execute();

                     if($prepare_category->rowCount() > 0){
                        while($fetch_category = $prepare_category->fetch(PDO::FETCH_ASSOC)){
               ?>
               <option class="dropdown-item" name="category">
                     <?php 
                     echo $fetch_category['category_id'] . "/" . $fetch_category['name']; 
                     ?>
               </option>
              
               <?php 
             
                     } } else { echo 'There is no category. Please create one first.';} 
            ?>    
            </select>
         </div>
                  <div class="form-group">
                    <label >Product Image</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image">
                        <label class="custom-file-label" ></label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" value="Add" name="add_product">
                </div>
              </form>
            </div>
            <!-- /.card -->

         
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="../../plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(function () {
bsCustomFileInput.init();
});
</script>
</body>
</html>
