<?php
session_start();
$conn = new mysqli("localhost", "root", "", "addproduct");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search keyword
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Get category (default all)
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : 'all';

// Base query
$sql = "SELECT * FROM products WHERE stock > 0";

// Filter by category if not 'all'
if ($category !== 'all') {
    $sql .= " AND category = '$category'";
}

//  Filter by search (using `name` column)
if (!empty($search)) {
    $sql .= " AND name LIKE '%$search%'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saplot de Manila - Products</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/product.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
<header class="navbar">
    <div class="logo">
      <img src="assets/Media (2) 1.png">
      <span class="brand-name">SAPLOT de MANILA</span>
    </div>
    <nav>
      <ul class="nav-links">
        <li><a href="home.php">HOME</a></li>
        <li><a href="product.php" class="active">SHOP</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="contact.php">CONTACT</a></li>
      </ul>
    </nav>
    <div class="nav-icons">
      <a href="#" class="icon-btn" id="search-icon">
    <img src="assets/search (1) 1.png" alt="Search">
  </a>
  
  <a href="cart.php" class="icon-btn cart-wrapper">
    <img src="assets/shopping-cart 1.png" alt="Cart" id="cartBtn">
    <span class="cart-count" id="cartCount">0</span>
  </a>
</div>
      <?php if (isset($_SESSION['user_id']) && isset($_SESSION['fullname'])): ?>
        <div class="profile-dropdown">
            <div class="profile-info">
                <i class="fa fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['fullname']); ?></span>
                <i class="fa fa-caret-down"></i>
            </div>
            <div class="dropdown-content">
                <a href="logout.php"><i class="fa fa-sign-out-alt"></i> Log Out</a>
            </div>
        </div>
      <?php else: ?>
        <button id="loginModalBtn" class="login-btn">Log In / Sign Up</button>
      <?php endif; ?>
    </div>
</header>

  
  <section class="hero" style="min-height: 12vh; padding: 0 80px; align-items: center; display: flex; justify-content: space-between;">
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>
    
    <div class="hero-content" style="padding: 0;">
      <h1 class="hero-heading" style="font-size: 1.8rem; margin: 0;">
        ALL Products
      </h1>
    </div>
    
    <div class="hero-image-container">
        <img src="assets/logo.png" alt="New Shoe Collection" class="hero-product-img" style="max-width: 180px; margin-top: 0;">
    </div>
  </section>

  <main class="container">
    <aside class="sidebar">
      <div class="sidebar-section">
        <h3>Browse By</h3>
        <ul>
          <li><a href="product.php?category=running">Running Shoes</a></li>
          <li><a href="product.php?category=basketball">Basketball Shoes</a></li>
          <li><a href="product.php?category=style">Style Shoes</a></li>
          <li><a href="product.php?category=all">All Products</a></li>
        </ul>
      </div>

      <div class="sidebar-section">
        <h3>Filter By</h3>
        <label for="price">Price: <span id="price-value"></span></label>
        <div class="price-slider">
          <input type="range" min="1000" max="10000" value="10000" id="price-range">
          <div class="price-labels">
            <span>₱1,000</span>
            <span>₱10,000</span>
          </div>
        </div>
      </div>
    </aside>

    <section class="products">
      <h2 style="text-transform: capitalize;"><?php echo $category; ?> Products</h2>
      <div class="product-grid">
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product_data = htmlspecialchars(json_encode([
                    "id" => $row["id"], "name" => $row["name"], "price" => $row["price"],
                    "image" => $row["image"], "rating" => $row["rating"]
                ]), ENT_QUOTES, 'UTF-8');

                // Define the onclick action based on login status
                $onclick_action = isset($_SESSION['user_id'])
                    ? "viewProduct(" . $product_data . ")"
                    : "document.getElementById('loginModal').style.display='block'";

                echo '
                <div class="product-card" data-price="' . $row["price"] . '" onclick="' . $onclick_action . '">
                    <div class="product-image-container">
                        <img src="' . $row["image"] . '" loading="lazy"/>
                        <div class="product-overlay"><button class="shop-button">Shop Now</button></div>
                    </div>
                    <div class="product-info">
                        <h4 class="product-name">' . $row["name"] . '</h4>
                        <p class="product-price">₱' . number_format($row["price"], 2) . '</p>
                    </div>
                </div>';
            }
        } else {
            echo "<p>No products found in this category.</p>";
        }
        ?>
      </div>
    </section>
  </main>

  <footer>
    <div class="footer-main">
        <div class="footer-left">
            <h3>Saplot<span>De Manila</span></h3>
            <p class="footer-links">
                <a href="home.php" class="link-1">Home</a><a href="product.php">Pricing</a>
                <a href="about.php">About</a><a href="contact.php">Contact</a>
            </p>
        </div>
        <div class="footer-center">
            <div><i class="fa fa-map-marker"></i><p><span>Fortuna, Floridablanca</span> Pampanga</p></div>
            <div><i class="fa fa-phone"></i><p>+639 131 019 6878</p></div>
            <div><i class="fa fa-envelope"></i><p><a href="mailto:support@company.com">Saplotdemanila@gmail.com</a></p></div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about">
                <span>About the company</span>
                Welcome to Saplot De Manila, your go to destination for exquisite footwear.
            </p>
            <div class="footer-icons">
                <a href="https://www.facebook.com/share/1FmsacvVRP/"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-copyright"><p>Copyright ©2025 All rights reserved</p></div>
  </footer>

  <div id="loginModal" class="modal">
    <div class="modal-content">
      <span class="close-btn" id="closeLoginModal">&times;</span>
      <h2>Login to Saplot</h2>
      <form method="POST" action="index.php">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="options">
          <label><input type="checkbox" name="remember"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" name="login">Login</button>
        <p class="register">Don't you have an account? <a href="#" id="showRegisterModal">Register</a></p>
      </form>
    </div>
  </div>

  <div id="registerModal" class="modal">
      <div class="modal-content">
          <span class="close-btn" id="closeRegisterModal">&times;</span>
          <h2>Register to Saplot</h2>
          <form method="POST" action="index.php">
              <input type="text" name="fullname" placeholder="Full Name" required>
              <input type="text" name="username" placeholder="Username" required>
              <input type="email" name="email" placeholder="Email" required>
              <input type="password" name="password" placeholder="Password" required>
              <input type="password" name="confirm_password" placeholder="Confirm Password" required>
              <button type="submit" name="register">Register</button>
              <p class="login">Have an account? <a href="#" id="showLoginModal">Login</a></p>
          </form>
      </div>
  </div>


  <script>
   function viewProduct(productData) {
  localStorage.setItem('selectedProduct', JSON.stringify(productData));
  window.location.href = `quantity.php?id=${productData.id}`;
}

    document.addEventListener("DOMContentLoaded", function() {
        // --- PROFILE DROPDOWN ---
        const profileDropdown = document.querySelector('.profile-dropdown');
        if (profileDropdown) {
            profileDropdown.addEventListener('click', function(event) {
                event.stopPropagation();
                this.classList.toggle('active');
            });
            window.addEventListener('click', function() {
                if(profileDropdown.classList.contains('active')) {
                    profileDropdown.classList.remove('active');
                }
            });
        }
        
        // --- MODAL CONTROLS ---
        const loginModal = document.getElementById("loginModal");
        const registerModal = document.getElementById("registerModal");
        const loginBtn = document.getElementById("loginModalBtn");
        const closeLoginModal = document.getElementById("closeLoginModal");
        const closeRegisterModal = document.getElementById("closeRegisterModal");
        const showRegisterModal = document.getElementById("showRegisterModal");
        const showLoginModal = document.getElementById("showLoginModal");

        if(loginBtn) loginBtn.onclick = () => { loginModal.style.display = "block"; }
        if(closeLoginModal) closeLoginModal.onclick = () => { loginModal.style.display = "none"; }
        if(closeRegisterModal) closeRegisterModal.onclick = () => { registerModal.style.display = "none"; }
        
        window.onclick = (event) => {
            if (event.target == loginModal) loginModal.style.display = "none";
            if (event.target == registerModal) registerModal.style.display = "none";
        }

        if(showRegisterModal) showRegisterModal.onclick = (e) => { e.preventDefault(); loginModal.style.display = "none"; registerModal.style.display = "block"; }
        if(showLoginModal) showLoginModal.onclick = (e) => { e.preventDefault(); registerModal.style.display = "none"; loginModal.style.display = "block"; }
    });
  </script>
  <script>
function updateCartCount() {
  const cartItems = JSON.parse(localStorage.getItem('cart')) || [];
  const count = cartItems.reduce((total, item) => total + (item.quantity || 1), 0);
  const cartCount = document.getElementById('cartCount');
  if (cartCount) cartCount.textContent = count;
}

updateCartCount();
</script>
</body>
</html>
<?php $conn->close(); ?>