<!DOCTYPE html>
<?php
include('config.php');
$sql = "SELECT firstname,email,balance FROM customers";
$result = $conn->query($sql);
$conn->close();
?>
<style>
  <?php include "styles.css" ?>
</style>
<html>
<head>
    <title>Bank</title>
  </head>
<body>
  <h1 class="bank-name">Spark Bank</h1>
        <table id="mytable">
        <thead>
            <th>
                Name
            </th>
            
            <th>
                Email
            </th>
            <th>
                Balance
            </th>
        </thead>
        <tbody>
        <?php
        if ($result->num_rows > 0) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
            ?>
            <tr onclick="addRowHandlers()" class="hove"> <td> <?php echo $row["firstname"] ?></td> 
            <td> <?php echo $row["email"] ?></td> 
            <td><?php echo $row["balance"]?></td>
          </tr>
         <?php }
        }?>
        </tbody>
        </table>
</body>
<script type="text/javascript" src="main.js"></script>
  </html>