<?php

session_start();

require 'dbconn.php';

// Input field navigation

function validate($inputData)
{
    global $conn;

    if ($inputData === null) {
        return null;
    }

    $validatedData = mysqli_real_escape_string($conn, $inputData);
    return trim($validatedData);
}

// Redirect from 1 page to another page with the message (status)

function redirect($url, $status)
{
    $_SESSION['status'] = $status;
    header('Location: ' . $url);
    exit(0);
}

// Display message or status after any process

function alertMessage()
{
    if (isset($_SESSION['status'])) {
        // echo $_SESSION['status'];
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            
           <h6>' .
            $_SESSION['status'] .
            '</h6> 
            
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        unset($_SESSION['status']);
    }
}

// Insert record using this function

function insert($tableName, $data)
{
    global $conn;

    $table = validate($tableName);

    // Converti il prezzo nel formato corretto (con il punto per i decimali)
    if (isset($data['price'])) {
        $data['price'] = str_replace(',', '.', $data['price']);
    }

    $columns = array_keys($data);
    $values = array_values($data);

    $finalColumns = implode(',', $columns);
    $finalValues = "'" . implode("', '", $values) . "'";

    $query = "INSERT INTO $table ($finalColumns) VALUES ($finalValues)";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Update data using this function

function update($tableName, $id, $data)
{
    global $conn;

    $table = validate($tableName);
    if (isset($data['price'])) {
        $data['price'] = str_replace(',', '.', $data['price']);
    }

    $id = validate($id);

    $updateDataString = '';

    foreach ($data as $column => $value) {
        $updateDataString .= $column . '=' . "'$value',";
    }

    $finalUpdateData = substr(trim($updateDataString), 0, -1);

    $query = "UPDATE $table SET $finalUpdateData WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function getAll

function getAll($tableName, $status = null)
{
    global $conn;

    $table = validate($tableName);
    $status = validate($status);

    if ($status == 'status') {
        $query = "SELECT * FROM $table WHERE status = '0'";
    } else {
        $query = "SELECT * FROM $table";
    }
    return mysqli_query($conn, $query);
}

// Function getById

function getById($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "SELECT * FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $response = [
            'status' => 500,
            'message' => 'Query failed: ' . mysqli_error($conn),
        ];
        return $response;
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $response = [
            'status' => 200,
            'data' => $row,
            'message' => 'Record Found',
        ];
    } else {
        $response = [
            'status' => 404,
            'message' => 'No Data Found',
        ];
    }

    return $response;
}

function getByPhone($tableName, $phone)
{
    global $conn;

    $table = validate($tableName);
    $phone = validate($phone);

    $query = "SELECT * FROM $table WHERE phone='$phone' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $response = [
            'status' => 500,
            'message' => 'Query failed: ' . mysqli_error($conn),
        ];
        return $response;
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $response = [
            'status' => 200,
            'data' => $row,
            'message' => 'Record Found',
        ];
    } else {
        $response = [
            'status' => 404,
            'message' => 'No Data Found',
        ];
    }

    return $response;
}

// Delete data from database using id

function delete($tableName, $id)
{
    global $conn;

    $table = validate($tableName);
    $id = validate($id);

    $query = "DELETE FROM $table WHERE id='$id' LIMIT 1";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function checkId

function checkParamId($type)
{
    if (isset($_GET[$type])) {
        if ($_GET[$type] != '') {
            return $_GET[$type];
        } else {
            return '<h5>No Id Found</h5>';
        }
    } else {
        return '<h5>No Id Given</h5>';
    }
}

// Logout Function

function logoutSession()
{
    unset($_SESSION['loggedIn']);
    unset($_SESSION['loggedInUser']);
}

function jsonResponse($status, $status_type, $message)
{
    $response = [
        'status' => $status,
        'status_type' => $status_type,
        'message' => $message,
    ];
    echo json_encode($response);
    return;
}

function getCount($tableName)
{
    global $conn;
    $table = validate($tableName);

    $query = "SELECT * FROM $table";
    $query_run = mysqli_query($conn, $query);
    if ($query_run) {
        $totalCount = mysqli_num_rows($query_run);
        return $totalCount;
    } else {
        return 'Something went wrong';
    }
}

function checkProductExistsByName($tableName, $productName)
{
    global $conn;

    $table = validate($tableName);
    $name = validate($productName);

    $escapedName = mysqli_real_escape_string($conn, $name);

    $query = "SELECT * FROM $table WHERE name = '$escapedName' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $response = [
            'status' => 500,
            'message' => 'Query failed: ' . mysqli_error($conn),
        ];
        return $response;
    }

    if (mysqli_num_rows($result) > 0) {
        // Prodotto con lo stesso nome esiste già
        $row = mysqli_fetch_assoc($result);
        $response = [
            'status' => 200,
            'data' => $row,
            'message' => 'Product with the same name already exists!',
        ];
    } else {
        // Prodotto non esiste ancora
        $response = [
            'status' => 404,
            'message' => 'Product with this name does not exist.',
        ];
    }

    return $response;
}

?>
