<?php include 'includes/header.php'; ?>
<div class="py-5" style="background-image: url('assets/images/HomePos.jpg'); background-size: cover;">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12 py-5 text-center">


                <?php alertMessage(); ?>

                <h3 class="mt-5" style="color: white">Sistema pagamenti e ricezione ordini Pizzeria</h3>
                <?php if (!isset($_SESSION['loggedIn'])) : ?>
                <a href="login.php" class="btn btn-primary mt-4">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
