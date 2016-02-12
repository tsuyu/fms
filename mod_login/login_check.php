<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function login_check($db) {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
        
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $sql = "SELECT aum_password FROM apps_user_main WHERE id = ? LIMIT 1";

        if ($stmt = $db->prepare($sql)) {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!!
                    $stmt->close();
                    $db->close();
                    return true;
                } else {
                    // Not logged in
                    $stmt->close();
                    $db->close();
                    return false;
                }
            } else {
                // Not logged in
                $stmt->close();
                $db->close();
                return false;
            }
        } else {
            // Could not prepare statement
            $db->close();
            return false;
            //redirect("index.php","Failed!");
        }
    } else {
        // Not logged in
        $db->close();
        return false;
    }
}
?>
