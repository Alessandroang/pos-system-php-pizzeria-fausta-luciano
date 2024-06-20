<?php include 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Order
                <a href="#" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="row row-cols-3 g-4">
                <?php
                $products = getAll('products');
                if ($products && mysqli_num_rows($products) > 0) {
                    while ($prodItem = mysqli_fetch_assoc($products)) {
                ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <img src="../<?= $prodItem['image'] ?>" class="card-img-top me-3"
                                    alt="<?= $prodItem['name'] ?>" style="width: 80px; height: 80px;">
                                <div>
                                    <h5 class="card-title"><?= $prodItem['name'] ?></h5>
                                    <p class="card-text">Price: <?= $prodItem['price'] ?></p>
                                    <form action="orders-code.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $prodItem['id'] ?>">
                                        <input type="hidden" name="product_name" value="<?= $prodItem['name'] ?>">
                                        <input type="hidden" name="product_price" value="<?= $prodItem['price'] ?>">
                                        <input type="number" name="quantity" value="1" class="form-control"
                                            style="width: 60px; display: inline-block;">
                                        <button type="submit" name="addItem" class="btn btn-primary ms-2">Add
                                            Item</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                    }
                } else {
                    echo '<p>No products found.</p>';
                }
                ?>
            </div>

            <hr>

            <h4>Order Items</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;
                        if (isset($_SESSION['productItems']) && !empty($_SESSION['productItems'])) {
                            $i = 1;
                            foreach ($_SESSION['productItems'] as $key => $item) {
                                $totalPrice += $item['price'] * $item['quantity'];
                        ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td>
                                <?= $item['quantity'] ?>
                            </td>
                            <td class="totalPrice"><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td><a href="order-item-delete.php?index=<?= $key ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">No items added</td></tr>';
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td id="orderTotal"><?= number_format($totalPrice, 2) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-2">
                <hr>
                <div class="row">


                    <div class="col-md-12">
                        <br />
                        <button class="btn btn-warning w-100 proceedToPlace">Proceed to place order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include 'includes/footer.php'; ?>
