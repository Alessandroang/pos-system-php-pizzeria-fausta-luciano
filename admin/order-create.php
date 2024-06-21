<?php include 'includes/header.php'; ?>

<div class="modal fade" id="addCustomerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add customer</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Enter customer name</label>
                    <input type="text" id="c_name" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Enter customer phone number</label>
                    <input type="text" id="c_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Enter customer Email (optional)</label>
                    <input type="text" id="c_email" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary saveCustomer">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Create Order
                <a href="#" class="btn btn-danger float-end">Back</a>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>

            <div class="table-responsive mb-3">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity Available</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $products = getAll('products');
                    if ($products) {
                        if (mysqli_num_rows($products) > 0) {
                            foreach ($products as $prodItem) {
                    ?>
                        <tr>
                            <td><?= $prodItem['id'] ?></td>
                            <td><img src="../<?= $prodItem['image'] ?>" style="width: 50px;height:50px" alt="Img">
                            </td>
                            <td><?= $prodItem['name'] ?></td>
                            <td><?= $prodItem['price'] ?></td>
                            <td><?= $prodItem['quantity'] ?></td>
                            <td>
                                <form action="orders-code.php" method="POST" style="display:inline-block;">
                                    <input type="hidden" name="product_id" value="<?= $prodItem['id'] ?>">
                                    <input type="number" name="quantity" value="1" min="1"
                                        max="<?= $prodItem['quantity'] ?>" class="form-control mb-2"
                                        style="width:80px; display:inline-block;">
                                    <button type="submit" name="addItem" class="btn btn-primary btn-sm">Add</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="6">No products found</td></tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6">Something went wrong</td></tr>';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h4 class="mb-0">Products in Order</h4>
        </div>
        <div class="card-body" id="productArea">
            <?php
        if (isset($_SESSION['productItems'])) {
            $sessionProducts = $_SESSION['productItems'];
            if(empty($sessionProducts)){
                unset($_SESSION['productItemIds']);
                unset($_SESSION['productItems']);
            }
            ?>
            <div class="table-responsive mb-3" id="productContent">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach($sessionProducts as $key => $item) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><img src="../<?= $item['image'] ?>" style="width: 50px;height:50px" alt="Img"></td>
                            <td><?= $item['name'] ?></td>
                            <td><?= $item['price'] ?></td>
                            <td>
                                <div class="input-group qtyBox">
                                    <input type="hidden" value="<?= $item['product_id'] ?>" class="prodId" />
                                    <button class="input-group-text decrement">-</button>
                                    <input type="text" value="<?= $item['quantity'] ?>" class="qty quantityInput" />
                                    <button class="input-group-text increment">+</button>
                                </div>
                            </td>
                            <td><?= number_format($item['price'] * $item['quantity'], 0) ?></td>
                            <td><a href="order-item-delete.php?index=<?= $key ?>" class="btn btn-danger">Remove</a></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <form action="orders-code.php" method="POST">
                            <button type="submit" name="saveOrder" class="btn btn-success w-100">Place Order</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        }
        else{
            echo '<h5>No items added</h5>';
        }
        ?>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
