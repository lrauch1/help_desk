<form method="post" action="/register">
    <table border="1">
        <tr>
            <th>First Name:</th>
            <td><input type="text" name="fname"></td>
        </tr>
        <tr>
            <th>Last Name:</th>
            <td><input type="text" name="lname"></td>
        </tr>
        <tr>
            <th>Username:</th>
            <td><input type="text" name="uname"></td>
        </tr>
        <tr>
            <th>Password:</th>
            <td><input type="password" name="pword"></td>
        </tr>
        <tr>
            <th>Confirm Password:</th>
            <td><input type="password" name="cpword"></td>
        </tr>
        <tr>
            <th></th>
            <td><input type="submit"></td>
        </tr>
        <tr>
            <td colspan="2" style="textalign:center;">
                <?php
                    if(isset($_GET['badconfirm']))
                        echo "<span style='colour:red;'>Passwords Don't Match!</span>";
                ?>
            </td>
        </tr>
    </table>
</form>