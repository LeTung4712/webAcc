<?php
include_once 'lib/session.php';
include_once 'classes/product.php';
include_once 'classes/cart.php';

$cart = new cart();
$totalQty = $cart->getTotalQtyByUserId();


if (isset($_REQUEST['ok'])) 
        {
            // Gán hàm addslashes để chống sql injection
            $search = addslashes($_GET['search']);
 
            // Nếu $search rỗng thì báo lỗi, tức là người dùng chưa nhập liệu mà đã nhấn submit.
            if (empty($search)) {
                echo "Yeu cau nhap du lieu vao o trong";
            } 
            else
            {
                $product = new product();
                $list = $product->getSearchByNameProducts((isset($_GET['search']) ? $_GET['search'] : 1));
                
            }
        }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://use.fontawesome.com/2145adbb48.js"></script>
    <script src="https://kit.fontawesome.com/a42aeb5b72.js" crossorigin="anonymous"></script>
    <title>Trang chủ</title>
</head>

<body>
    <?php include('inc/header.php')?>

    <section class="banner"></section>

    <div class="featuredProducts">
        <h1>Sản phẩm tìm kiếm cho từ khóa '<?php echo $_GET['search']; ?>'</h1>
    </div>
    
    <div class="container">
        <?php if ($list) {
        foreach ($list as $key => $value) { ?>
        <div class="card">
            <div class="imgBx">
                <a href="detail.php?id=<?= $value['id'] ?>"><img src="admin/uploads/<?= $value['image'] ?>" alt=""></a>
            </div>
            <div class="content">
                <div class="productName">
                    <a href="detail.php?id=<?= $value['id'] ?>">
                        <h3><?= $value['name'] ?></h3>
                    </a>
                </div>
                <div>
                    Đã bán: <?= $value['soldCount'] ?>
                </div>
                <div class="original-price">
                    <?php
                        if ($value['promotionPrice'] < $value['originalPrice']) { ?>
                    Giá gốc: <del><?= number_format($value['originalPrice'], 0, '', ',') ?>VND</del>
                    <?php } else { ?>
                    <p>.</p>
                    <?php } ?>
                </div>
                <div class="price">
                    Giá bán: <?= number_format($value['promotionPrice'], 0, '', ',') ?>VND
                </div>
                <div class="action">
                    <a class="add-cart" href="add_cart.php?id=<?= $value['id'] ?>">Thêm vào giỏ</a>
                    <a class="detail" href="detail.php?id=<?= $value['id'] ?>">Xem chi tiết</a>
                </div>
            </div>
        </div>
        <?php }
        }else { ?>
        <h3>Không có sản phẩm nào...</h3>
        <?php  }
        ?>
    </div>
    <?php
       include('inc/footer.php');
    ?>
</body>

</html>