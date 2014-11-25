<?php
$ses = Session::all();
?>
<!DOCTYPE html>
<html>
    <head>
     <!--   <script src="//efalder.ca/jquery-2.1.1.min.js"></script> -->
        <script src="/js.js"></script>
        <script src="//cdn.datatables.net/1.10.3/js/jquery.dataTables.min.js"></script> 
        <link rel="stylesheet" href="//cdn.datatables.net/1.10.3/css/jquery.dataTables.min.css"> 
        <script>
            $(document).ready(function() {
                $("#sortme").DataTable();
            });
        </script>
        <meta charset="UTF-8">
        <title></title>
        <?php
        if (isset($_GET['updated']))
            echo<<<'EOD'
<script>
    $(document).ready(function(){
        $('#update').fadeIn('slow').delay(3000).fadeOut('slow');
    });
</script>
EOD;
        ?>
    </head>
    <body>
        <table border=1 style="width:100%;">
            <tr>
                <td>
                    <?php
                    echo <<<EOD
                    <strong>
                        Welcome, {$ses['me']->type} {$ses['me']->fname} {$ses['me']->lname}!
                    </strong>
                </td>
                <td>
                    <a href="/secure/browse">Home</a>
                </td>
EOD;
                    if ($ses['me']->type == "Admin")
                        echo<<<EOD
    <td>
        <a href="/admin/tickets">Admin Controls</a>
    </td>
EOD;
                    echo<<<EOD
                <td>       
                <a href="/secure/settings">Account Settings</a>
                </td>     
                <td>
                    <a href="/logout">Logout</a>
                </td>
            </tr>
        </table>
EOD;

                    