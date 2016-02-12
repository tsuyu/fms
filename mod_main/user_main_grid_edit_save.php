<?php

$db = MySQL::getInstance();
$id = decode($_GET['id']);
if (isset($_POST['email'], $_POST['name'], $_POST['role'])) {
    // Sanitize and validate the data passed in
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        redirect("home.php?mod=" . encode('1') . "&app=" . encode('user_main_grid_edit') . "&id=" . $_GET['id'] . "", "The email address you entered is not valid!");
    }

    if (isset($_POST['chkreset']) && $_POST['chkreset'] == "on") {
        $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
        if (strlen($password) != 128) {
            // The hashed pwd should be 128 characters long.
            // If it's not, something really odd has happened
            redirect("home.php?mod=" . encode('1') . "&app=" . encode('user_main_grid_edit') . "&id=" . $_GET['id'] . "", "Invalid password configuration.!");
        }
    }

    // TODO:
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
    // Create a random salt
    $random_salt = hash('sha512', uniqid(mt_rand(), true));

    // Create salted password
    $password = hash('sha512', $password . $random_salt);

    // Insert the new user into the database
    if (isset($_POST['chkreset']) && $_POST['chkreset'] == "on") {
        $sql = "UPDATE `apps_user_main` SET `aum_name` = ?, `aum_email` = ?, `aum_phone` = ?, `aum_password` = ?,`aum_salt` = ?,`aum_role` = ?
            WHERE aum_seq_no = ?";
    } else {
        $sql = "UPDATE `apps_user_main` SET `aum_name` = ?, `aum_email` = ?, `aum_phone` = ?, `aum_role` = ? WHERE aum_seq_no = ?";
    }

    if ($stmt = $db->prepare($sql)) {

        if (isset($_POST['chkreset']) && $_POST['chkreset'] == "on") {
            $stmt->bind_param('sssssss', $name, $email, $phone, $password, $random_salt, $role, $id);
        } else {
            $stmt->bind_param('sssss', $name, $email, $phone, $role, $id);
        }

        // Execute the prepared query.
        if (!$stmt->execute()) {
            redirect("home.php?mod=" . encode('1') . "&app=" . encode('user_main_grid_edit') . "&id=" . $_GET['id'] . "", "Update failure.!");
        }
    }
    $stmt->close();
    $db->close();
    redirect("home.php?mod=" . encode('1') . "&app=" . encode('user_main_grid_edit') . "&id=" . $_GET['id'] . "&page=&ipp=", "Update success");
}
?>