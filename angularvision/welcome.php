<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
<?php include "./header.php"; ?> 
 <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
    </div>
    <p>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
    <div class="bundle-content-container">
    <div class="bundle-content"> 
        <a href="./brand.php?id=1">
            <div class="bundle-icon"><i class="fas fa-cog"></i></div>
            <div class=bundle-text><span>All Catagories</span></div>
        </a>
    </div> 
    <div class="bundle-content"> 
        <a href="./brand.php?id=2">
            <div class="bundle-icon"><i class="fas fa-leaf"></i></div>
            <div class=bundle-text><span>Natural</span></div>
        </a>
    </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=3">
            <div class="bundle-icon"><i class="fas fa-kaaba"></i></div>
            <div class=bundle-text style="padding-top: 28px;"><span>Religious</span></div>
        </a>
   </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=4">
            <div class="bundle-icon"><i class="fas fa-brain"></i></div>
            <div class=bundle-text style="padding-top: 32px;"><span>Scientific</span></div>
        </a>
    </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=5">
            <div class="bundle-icon"><i class="fab fa-linux"></i></div>
            <div class=bundle-text><span>Life Style</span></div>
        </a>
   </div>
    <div class="bundle-content"> 
        <a href="./brand.php?id=6">
            <div class="bundle-icon"><i class="fas fa-camera"></i></div>
            <div class=bundle-text><span>Others</span></div>
        </a>
   </div>
    
</div>
<?php include "./footer.php"; ?>