<?php include 'includes/header.php';

if (isset($_SESSION['loggedIn'])) {
   ?>
<script>
    window.location.href = 'index.php'
</script>
<?php
} else {
    # code...
}



?>

<div class="py-5">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <?php alertMessage(); ?>

                    <div class="card-body">
                        <h1 class="card-title text-center">Login Fausto e Luciano Pizzeria</h1>

                        <form action="login-code.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <button type="submit" name="loginBtn" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
