<?php
   
    include('config.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>

    <h1>Category</h1>

    <a href="add-category.php">Add Category</a>
    <br><br>
    <table width="100%" border="1">
        <thead>
            <tr>
                <td>Category ID</td>
                <td>Category Name</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql = "SELECT * FROM category";
            $result = $con->query($sql);

            while($row = $result->fetch_assoc()) {

                echo "<tr>";

                    echo "<td>".$row['category_id']."</td>";
                    echo "<td>".$row['category_name']."</td>";
                    echo "<td><a href='edit-category.php?id=".$row['category_id']."'>Edit</a> <a href='delete-category.php?id=".$row['category_id']."'>Delete</a></td>";
                echo "</tr>";
            }


            ?>
        </tbody>
    </table>

</body>
</html>