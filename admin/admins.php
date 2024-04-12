<?php include 'includes/header.php'; ?>


<div class="container-fluid px-4">
    <div class="card mt-4 shadow-sm">
        <div class="card-header">
            <h4 class="mb-0">Admins/staff
                <a href="admins-create.php" class="btn btn-primary float-end">Add Admin</a>
            </h4>
            <div class="card-body">
                <?php alertMessage(); ?>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Is Ban</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $admins = getAll('admins');
                            if(!$admins){
                                echo '<h4>Something went wrong </h4>';
                                return false;
                            }
                            if(mysqli_num_rows($admins) > 0)
                            {
                            ?>
                            <?php foreach($admins as $adminItem) : ?>
                            <tr>
                                <td>
                                    <?= $adminItem['id'] ?>
                                </td>
                                <td>
                                    <?= $adminItem['name'] ?>
                                </td>
                                <td>
                                    <?= $adminItem['email'] ?>
                                </td>
                                <td>
                                    <span class="badge <?= $adminItem['is_ban'] == 1 ? 'bg-danger' : 'bg-primary' ?>">
                                        <?= $adminItem['is_ban'] == 1 ? 'Not Active' : 'Active' ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="admins-edit.php?id=<?= $adminItem['id'] ?>"
                                        class="btn btn-success btn-sm">Edit</a>
                                    <a href="admins-delete.php?id=<?= $adminItem['id'] ?>"
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
