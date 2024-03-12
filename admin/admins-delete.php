<?php

require '../config/function.php';

$paraRestultId = checkParamId('id');

if (is_numeric($paraRestultId)) {
    $adminId = validate($paraRestultId);
    // echo $adminId;
    $admin = getById('admins', $adminId);

    if ($admin['status'] == 200) {
        $adminDeleteRes = delete('admins', $adminId);
        if ($adminDeleteRes) {
            redirect('admins.php', 'Admin Deleted Succesfully.');
        } else {
            redirect('admins.php', 'Something Went Wrong.');
        }
    } else {
        redirect('admins.php', $admin['message']);
    }
} else {
    redirect('admins.php', 'Something Went Wrong.');
}

?>
