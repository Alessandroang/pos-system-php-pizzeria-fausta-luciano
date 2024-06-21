<?php include 'includes/header.php'; ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Product
                <a href="products-create.php" class="btn btn-primary float-end">Add Product</a>
            </h4>
            <div class="card-body">
                <?php alertMessage(); ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Quantity Available</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $products = getAll('products');
                            if(!$products){
                                echo '<h4>Something went wrong </h4>';
                                return false;
                            }
                            if(mysqli_num_rows($products) > 0)
                            {
                            ?>
                            <?php foreach($products as $item) : ?>
                            <tr>
                                <td>
                                    <?= $item['id'] ?>
                                </td>
                                <td>
                                    <img src="../<?= $item['image'] ?>" style="width: 50px;height:50px" alt="Img">
                                </td>
                                <td>
                                    <?= $item['name'] ?>
                                </td>
                                <td>
                                    <span class="badge <?= $item['status'] == 1 ? 'bg-danger' : 'bg-primary' ?>">
                                        <?= $item['status'] == 1 ? 'Hidden' : 'Visible' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= $item['quantity'] ?>
                                </td>
                                <td>
                                    <a href="products-edit.php?id=<?= $item['id'] ?>"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <a href="products-delete.php?id=<?= $item['id'] ?>" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Sei sicuro di voler eliminare questo prodotto?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php 
                            }
                            else{
                                ?>
                            <tr>
                                <td colspan="6">
                                    No record found
                                </td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
