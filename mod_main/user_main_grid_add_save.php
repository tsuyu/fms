<?php

$db = MySQL::getInstance();

if (isset($_POST['name'], $_POST['username'], $_POST['email'], $_POST['p'], $_POST['role'])) {
    // Sanitize and validate the data passed in
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid_add')."&page=&ipp=",
                "The email address you entered is not valid!");
    }

    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid_add')."&page=&ipp=",
                "Invalid password configuration.!");
    }

    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //

    $prep_stmt = "SELECT `aum_username` FROM `apps_user_main` WHERE `aum_email` = ? LIMIT 1";
    $stmt = $db->prepare($prep_stmt);

    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $stmt->close();
            $db->close();
            redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid_add')."&page=&ipp=",
                "A user with this email address already exists.!");
        }
    } else {
        $stmt->close();
        $db->close();
        redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid_add')."&page=&ipp=",
                "Database error.!");
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
        $status = "Y";
        if ($stmt = $db->prepare("INSERT INTO `apps_user_main` (`aum_name`, `aum_username`, `aum_email`, `aum_phone`, `aum_password`, `aum_salt`,`aum_role`,`aum_status`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
            $stmt->bind_param('ssssssss', $name, $username, $email, $phone, $password, $random_salt, $role, $status);
            // Execute the prepared query.
            if (!$stmt->execute()) {
                redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid_add')."&page=&ipp=",
                "Fail!");
            }
        }
        $stmt->close();
        $db->close();
        redirect("home.php?mod=".encode('1')."&app=".encode('user_main_grid')."&page=&ipp=",
                "Commit!");
}
?>