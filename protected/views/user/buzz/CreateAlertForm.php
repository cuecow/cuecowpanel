<?php
session_start();
?>
<!DOCTYPE html>
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>

    <body>
        <?php
        $user = $_SESSION['user'];
        if ($user == null) { // no user, no session, then die
            die("Session expired.. Please relogin.");
        }
        ?>
        <h2>Create Alert for <?php echo $user ?></h2>
        <form action="CreateAlert.php" method="post">
            <table>
                <tr>
                    <td>Query:</td>
                    <td>
                        <input type="text" name="Query" size="50"></input>
                    </td>
                </tr>

                <tr>
                    <td>Type:</td>
                    <td>
                        <select size="1" name="Type">
                            <option selected>Everything</option>
                            <option>Blogs</option>
                            <option>Video</option>
                            <option>Discussions</option>
                            <option>News</option>
                        </select>

                    </td>
                </tr>
                <tr>
                    <td>Frequency:</td>
                    <td>
                        <select size="1" name="Frequency">
                            <option selected>As-it-happens</option>
                            <option>Once a day</option>
                            <option>Once a week</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Volume:</td>
                    <td>
                        <select size="1" name="Volume">
                            <option selected>All results</option>
                            <option>Only the best results</option>
                        </select></td>
                </tr>
                <tr>
                    <td>Deliver to:</td>
                    <td>

                        <select size="1" name="Delivery">
                            <option selected>feed</option>
                            <option><?php echo $user ?></option>
                        </select></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Create Alert"></td>
                </tr>
            </table>

    </body>
</table>
</form>

</html>