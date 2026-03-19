<?php
include 'config.php';
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['add_to_cart'])) {
    if (!$user_id) {
        header('location:login.php');
        exit;
    }

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <section class="home">
        <div class="content">
            <h3>Hand Picked Book to your door.</h3>
            <p>At Book's Wonders, we bring the joy of reading right to your doorstep. Explore our extensive collection of books across all genres and find the perfect addition to your bookshelf. From the latest bestsellers to timeless classics, our carefully curated selection has something for every reader.</p>
            <a href="about.php" class="white-btn">discover more</a>
        </div>
    </section>

    <section class="products">
        <h1 class="title">Latest Products</h1>
        
        <!-- Filter Section -->
        <div class="filters">
            <form id="filter-form" action="" method="GET" class="filter-form">
                
                <select name="category" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Select Category</option>
                    <option value="novel">Novel</option>
                    <option value="sanatan_dharma">Spirtual</option>
                    <option value="horror">Horror</option>
                    <option value="other">Other Category</option>
                    <!-- Add more categories as needed -->
                </select>
                <select name="price_range" onchange="document.getElementById('filter-form').submit()">
                    <option value="">Select Price Range</option>
                    <option value="0-500">₹0 - ₹500</option>
                    <option value="500-1000">₹500 - ₹1000</option>
                    <option value="1000-1500">₹1000 - ₹1500</option>
                    <!-- Add more price ranges as needed -->
                </select>
            </form>
        </div>

        <div class="box-container">
            <?php
            // Retrieve selected filters
            $category = isset($_GET['category']) ? $_GET['category'] : '';
            $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';

            // Build the query with filters
            $query = "SELECT * FROM products WHERE 1";

            if ($category) {
                $query .= " AND category = '$category'";
            }
            if ($price_range) {
                list($min_price, $max_price) = explode('-', $price_range);
                $query .= " AND price BETWEEN $min_price AND $max_price";
            }

            $select_products = mysqli_query($conn, $query) or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price">₹<?php echo $fetch_products['price']; ?>/-</div>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">No products found!</p>';
            }
            ?>
        </div>
        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">Load More</a>
        </div>
    </section>

    <section class="about">
        <div class="flex">
            <div class="image">
                <img src="images/about-img.jpg" alt="">
            </div>
            <div class="content">
                <h3>About Us</h3>
                <p>Welcome to Book's Wonders, your one-stop online destination for all your reading needs! We offer a diverse selection of books across various genres, including fiction, non-fiction, self-help, academic, and spirtual or more. Our mission is to connect readers with the books they love, providing a seamless and enjoyable shopping experience. Whether you’re looking for the latest bestsellers or timeless classics, we’ve got you covered. Dive into the world of literature with us and discover your next great read today!</p>
                <a href="about.php" class="btn">Read More</a>
            </div>
        </div>
    </section>

    <section class="home-contact">
        <div class="content">
            <h3>Have Any Questions?</h3>
            <p>We're here to help! If you have any questions about your online book shopping experience, please don't hesitate to contact our customer support team. Whether you need assistance with finding a book, placing an order, or tracking your shipment, we're just a message away. Reach out to us via email, chat, or phone, and we'll be happy to assist you. Happy reading!</p>
            <a href="contact.php" class="white-btn">Contact Us</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>
</html>


