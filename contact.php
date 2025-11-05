<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Saplot de Manila</title>
  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/contact.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
  <style>
    .form-message { padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; }
    .form-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .form-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
  </style>
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
        <li><a href="product.php">SHOP</a></li>
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="contact.php" class="active">CONTACT</a></li>
      </ul>
    </nav>
    <div class="nav-icons">
      <a href="#" class="icon-btn" id="search-icon"><img src="assets/search (1) 1.png" alt="Search"></a>
      <a href="cart.php" class="icon-btn">
        <img src="assets/shopping-cart 1.png" alt="Cart" id="cartBtn">
      </a>
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
        Contact Us
      </h1>
    </div>
    
    <div class="hero-image-container">
        <img src="assets/logo.png" alt="New Shoe Collection" class="hero-product-img" style="max-width: 180px; margin-top: 0;">
    </div>
  </section>

  <main>
    <section class="contact-container">
      <div class="contact-info">
        <h3>Contact Information</h3>
        <p>Have a question or need help with an order? Fill out the form and our team will get back to you within 24 hours.</p>
        <div class="info-item"><i class="fa fa-phone"></i><span>+639 999 999 9999</span></div>
        <div class="info-item"><i class="fa fa-envelope"></i><span>Saplotdemanila@gmail.com</span></div>
        <div class="info-item"><i class="fa fa-map-marker"></i><span>Fortuna, Floridablanca, Pampanga</span></div>
      </div>
      <div class="contact-form-wrapper">
        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="form-message form-success">✓ Thank you for your message! We will get back to you shortly.</div>
        <?php elseif(isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="form-message form-error">✗ There was an error sending your message. Please try again.</div>
        <?php endif; ?>

        <form action="submit_inquiry.php" method="POST" class="contact-form">
          <div class="form-row">
            <div class="form-group">
              <label for="fname">First Name</label>
              <input type="text" id="fname" name="fname" required>
            </div>
            <div class="form-group">
              <label for="lname">Last Name</label>
              <input type="text" id="lname" name="lname" required>
            </div>
          </div>
          <div class="form-group full-width">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group full-width">
            <label for="message">Message / Inquiry</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>
          <button type="submit" class="submit-btn">Send Message</button>
        </form>
      </div>
    </section>
  </main>
  
  <footer>
    <div class="footer-main">
        <div class="footer-left">
            <h3>Saplot<span>De Manila</span></h3>
            <p class="footer-links">
                <a href="home.php">Home</a>
                <a href="product.php">Pricing</a>
                <a href="about.php">About</a>
                <a href="contact.php">Contact</a>
            </p>
        </div>
        <div class="footer-center">
            <div><i class="fa fa-map-marker"></i><p><span>Fortuna, Floridablanca</span> Pampanga</p></div>
            <div><i class="fa fa-phone"></i><p>+639 131 019 6878</p></div>
            <div><i class="fa fa-envelope"></i><p><a href="mailto:Saplot09209@gmail.com">Saplotdemanila@gmail.com</a></p></div>
        </div>
        <div class="footer-right">
            <p class="footer-company-about"><span>About the company</span>Welcome to Saplot De Manila, your go to destination for exquisite footwear.</p>
            <div class="footer-icons">
                <a href="https://www.facebook.com/share/1FmsacvVRP/"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-copyright"><p>Copyright ©2025 All rights reserved</p></div>
  </footer>

    <div id="loginModal" class="modal">
        <div class="modal-content">
          <span class="close-btn">&times;</span>
          <h2>Login to Saplot</h2>
          <form method="POST" action="index.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <div class="options">
              <label><input type="checkbox" name="remember"> Remember me</label>
              <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" name="login">Login</button>
            <p class="register">Don't you have an account? <a href="#">Register</a></p>
          </form>
        </div>
    </div>

    <div id="registerModal" class="modal">
        <div class="modal-content">
          <span class="close-btn">&times;</span>
          <h2>Register to Saplot</h2>
          <form method="POST" action="index.php">
              <input type="text" name="fullname" placeholder="Full Name" required>
              <input type="text" name="username" placeholder="Username" required>
              <input type="email" name="email" placeholder="Email" required>
              <input type="password" name="password" placeholder="Password" required>
              <input type="password" name="confirm_password" placeholder="Confirm Password" required>
              <button type="submit" name="register">Register</button>
              <p class="login">Have an account? <a href="#">Login</a></p>
          </form>
        </div>
    </div>
  
  <script>
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
        
        if (loginModal && registerModal) {
            const closeLoginModal = loginModal.querySelector(".close-btn");
            const closeRegisterModal = registerModal.querySelector(".close-btn");
            const showRegisterLink = loginModal.querySelector(".register a");
            const showLoginLink = registerModal.querySelector(".login a");

            if(loginBtn) {
                loginBtn.onclick = () => { loginModal.style.display = "block"; }
            }
            if(closeLoginModal) {
                closeLoginModal.onclick = () => { loginModal.style.display = "none"; }
            }
            if(closeRegisterModal) {
                closeRegisterModal.onclick = () => { registerModal.style.display = "none"; }
            }
            if(showRegisterLink) {
                showRegisterLink.onclick = (e) => { 
                    e.preventDefault(); 
                    loginModal.style.display = "none"; 
                    registerModal.style.display = "block"; 
                }
            }
            if(showLoginLink) {
                showLoginLink.onclick = (e) => { 
                    e.preventDefault(); 
                    registerModal.style.display = "none"; 
                    loginModal.style.display = "block"; 
                }
            }
            
            window.addEventListener('click', (event) => {
                if (event.target == loginModal) loginModal.style.display = "none";
                if (event.target == registerModal) registerModal.style.display = "none";
            });
        }
    });
  </script>

</body>
</html>