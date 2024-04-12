<?php include 'includes/header.php'; ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Categories
                <a href="categories-create.php" class="btn btn-primary float-end">Add Category</a>
            </h4>
            <div class="card-body">
                <?php alertMessage(); ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>

                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $categories = getAll('categories');
                            if(!$categories){
                                echo '<h4>Something went wrong </h4>';
                                return false;
                            }
                            if(mysqli_num_rows($categories) > 0)
                            {
                            ?>
                            <?php foreach($categories as $item) : ?>
                            <tr>
                                <td>
                                    <?= $item['id'] ?>
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
                                    <a href="categories-edit.php?id=<?= $item['id'] ?>"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <a href="categories-delete.php?id=<?= $item['id'] ?>"
                                        class="btn btn-danger btn-sm">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php 
                            }
                            else{
                                ?>
                            <tr>
                                <td colspan="4">
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
