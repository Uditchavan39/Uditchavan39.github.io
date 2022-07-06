<!DOCTYPE html>
<?php
include('config.php'); 
$customer_name="NULL";
if(isset($_GET["name"])){
$customer_name = trim($_GET["name"]);
}
$sql = "SELECT firstname,email,balance FROM customers where firstname = '$customer_name'";
$result = $conn->query($sql);
$drop="SELECT firstname FROM customers where firstname !='$customer_name'";
$dropdown=$conn->query($drop);

$row = $result->fetch_assoc();
$firstname = "NULL";
$email="NULL";
$balance="NULL";
if(isset($row)){
$firstname = $row['firstname'];
$email=$row['email'];
$balance=$row['balance'];
}
?>
<html>
<link rel="stylesheet" href="styles.css">

<head>
	<title>Bank</title>
</head>

<body>
	<h1 class="bank-name">Spark Bank</h1>
	<table>
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
			<tr class="remove-hover">
				<td>
					<?php
			 echo $firstname; ?>
				</td>
				<td>
					<?php 
			echo $email ;?>
				</td>
				<td>
					<?php 
			 echo $balance?>
				</td>
			</tr>
		</tbody>

	</table>
	<table>
		<thead>
			<tr>
				<th colspan="3">Make Transaction</th>
			</tr>
			<tr>
				<th>From</th>
				<th>To</th>
				<th>Amount</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<?php 
			echo $customer_name; 
			?>
				</td>
				<td class="dropdown">
					<form action="" name="client_name" method="post" id="payment">
						<select name="clientlist" class="drop-expand" required>
							<?php
					 if(isset($dropdown)){
		 while($list = $dropdown->fetch_assoc()) {
            ?>
							<option value="<?php echo $list[" firstname"];?>">
								<?php echo $list["firstname"]; ?>
							</option>

							<?php }}?>
						</select>
				</td>
				<td>
					<input type="number" required="true" id="input-amount" class="drop-expand" name="amount" min="0.01"
						onkeypress="return event.charCode != 45" max="<?php echo $balance?>">
					</form>
				</td>
			</tr>
		</tbody>
	</table>

	<div> <button onclick="transaction()" type="submit" class="butt-submit">PROCEED</button>
	</div>
	<?php 
$transfer_query = "SELECT `from-customer`,`to-customer`,`amount` FROM `transfers` where `from-customer` = '$customer_name' OR `to-customer` = '$customer_name'";
$res = $conn->query($transfer_query);

?>
	<table>
		<thead>
			<tr>
				<th colspan="3">Transactions</th>
			</tr>
			<tr>
				<th>From</th>
				<th>To</th>
				<th>Amount</th>
			</tr>
		<tbody>
			<?php
					if (!empty($res) && $res->num_rows > 0) {
					  // output data of each row
					  while($transact = $res->fetch_assoc()) {
						?>
			<tr>
				<td>
					<?php echo $transact["from-customer"] ?>
				</td>
				<td>
					<?php echo $transact["to-customer"] ?>
				</td>
				<td>
					<?php echo $transact["amount"]?>
				</td>
			</tr>
			<?php }
					}?>
		</tbody>
		</thead>
	</table>
</body>

<?php
if(isset($_POST["clientlist"])){

	// sender balance update
 $selected_name_to = trim($_POST["clientlist"]);
 $transfer_amount=$_POST["amount"];
 $selected_name_from=$customer_name;
 
 $from_balance=$balance-$transfer_amount;

 $sql_update = "UPDATE customers set balance='$from_balance' where firstname = '$selected_name_from'";
 $result = $conn->query($sql_update);
 
 // Receiver balance update
 $qur="SELECT balance FROM customers where firstname ='$selected_name_to'";
$dropp=$conn->query($qur);
$list = $dropp->fetch_assoc();

 $list_balanc=$list['balance'];
 $to_balance=$list_balanc+$transfer_amount;
 
 $sql_update = "UPDATE customers set balance='$to_balance' where firstname = '$selected_name_to'";
 $result = $conn->query($sql_update);

// transfer table insert transaction
$sql_transfers = "INSERT INTO `transfers`(`from-customer`, `to-customer`, `amount`) VALUES ('$selected_name_from','$selected_name_to','$transfer_amount')";
$result = $conn->query($sql_transfers);

$conn->close();
 header("Location: in.php");

}
?>

</html>
<script type="text/javascript" src="main.js"></script>