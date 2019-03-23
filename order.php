<?php  
	include('session.php');
	
	if(!isset($_SESSION['login_user'])) {
		header("location: index.php");
	}
	if(isset($_POST['btn_search']))
	{
    $search = $_POST['search'];
		// search in all table columns
		// using concat mysql function
		$query = "SELECT * FROM `customer_order` WHERE CONCAT(`order_id`, `customer_id`, `timestamp`) LIKE '%".$search."%'";
		$search_result = filterTable($query);
    
	}
	else {
		$query = "SELECT * FROM `customer_order`";
		$search_result = filterTable($query);
	}

	// function to connect and execute the query
	function filterTable($query)
	{
		$connect = mysqli_connect("localhost", "root", "", "kusina1");
		$filter_Result = mysqli_query($connect, $query);
		return $filter_Result;
	}
?>
<?php
	$con = new mysqli('localhost', 'root', '', 'kusina1') or die(mysqli($mysqli));
	$sql = "SELECT * FROM customer";
	$query_cus = mysqli_query($con,$sql);
?>
<!DOCTYPE html>
<html lang="en"> 
      <head>  
           <title>Kusina Online</title>  
           <meta charset="utf-8"/>
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
			<link rel="stylesheet" type="text/css" href="style1.css">
			<script type="text/javascript" src="bootstrap/js/jquery-slim.min.js"></script>
			<script type="text/javascript" src="bootstrap/js/popper.min.js"></script>
			<script type="text/javascript" src="bootstrap/js/bootstrap.js"></script>
      </head>  
      <body>  
         <div class="row" style="background-color:#2F4F4F">
			<div style="background-image: url('kusina.jpg');background-size: contain; height: 400px;background-repeat: no-repeat;position: relative" class="col-8">
				 <button id="btnGroupDrop1" style="position: absolute;top: 10px;right: 90px" type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Home
				</button>
				<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
				  <a class="dropdown-item" href="customer.php">Customer</a>
				  <a class="dropdown-item" href="menu.php">Menu</a>
				  <a class="dropdown-item" href="reports.php">Reports</a>
				</div>

				<a style="position: absolute;top: 10px;right: 30px;text-align: right" data-toggle="modal" data-target="#exampleModalCenter1" href=""><img src="add.png" width="40" height="40"></a>
				<form style="position: absolute;bottom: 5px" action="process2.php" method="post">
					<div class="row">
						<div class="col-sm-3">
							<select name="order_id" class="form-control form-control-sm" value="<?php echo $order_id ;?>" required>
								<?php
									$con = new mysqli('localhost', 'root', '', 'kusina1') or die(mysqli($mysqli));
									$sql = "SELECT * FROM customer_order";
									$query_or = mysqli_query($con,$sql);
								?>
								<?php while($row = mysqli_fetch_array($query_or)):?>
									<option value="<?php echo $row['order_id'];?>"><?php echo $row['order_id'];?></option>
								<?php endwhile;?>
							</select>
						</div>
						<div class="col-sm-3">
							<select id="menus" name="menu_id" class="form-control form-control-sm" value="<?php echo $order_id ;?>" required>
								<?php
									$con = new mysqli('localhost', 'root', '', 'kusina1') or die(mysqli($mysqli));
									$sql = "SELECT * FROM menu";
									$query_menu = mysqli_query($con,$sql);
								?>
								<?php while($row = mysqli_fetch_array($query_menu)):?>
									<option value="<?php echo $row['menu_id'];?>" data-price="<?php echo $row['price'];?>"><?php echo $row['menu_name'];?></option>
								<?php endwhile;?>
							</select>
						</div>
						<div class="col-sm-2">
							<input id="prices" type="number" class="form-control form-control-sm" name="price" placeholder="price" value="" disabled>
						</div>
						<div class="col-sm-2">
							<input id="txt1" type="number" class="form-control form-control-sm" name="quantity" placeholder="quantity" value="" required>
						</div>
						<div class="col-sm-2">
							<input id="answer" type="submit" class="form-control btn btn-primary btn-sm" name="item" value="Add Items">
						</div>
					</div>
					<script>
						$(document).ready(function(){
							$( "#menus" ).change(function(){
								$('#prices').val($(this).find(':selected').data('price'))
							});
						});
					</script>
				
			</div>
			<div class="col-sm-4" style="color:#00FF00;position: relative;border-style: solid">
				<h1><p style="position: absolute;bottom: 30px;right: 30px;text-align: right">&#8369; <span id="txt3" ></span></p><h1>
				<script>
					$(document).ready(function(){
					 
					  $("#answer").click(function(){
						  $("#txt3").text($("#prices").val() * $("#txt1").val())
					  });
					   $("#clear").click(function(){
						$("#txt3").val(0);
					  });
					 
					  
					});
				</script>
			</div>
			</form>
		 </div>
		<div class="row">
			<div class="col-sm-7" style="border-style: solid">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Order ID</th>
								<th>Menu ID</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Total</th>
								<th>Action</th>
							</tr>
						</thead>
						<?php
							$con = new mysqli('localhost', 'root', '', 'kusina1') or die(mysqli($mysqli));
							$sql = "SELECT * FROM order_items";
							$query_items = mysqli_query($con,$sql);
							$result = mysqli_num_rows($query_items);
							$gtotal = 0;
							if ($result > 0){
								while ($row = mysqli_fetch_assoc($query_items)){
								$order = $row['order_id'];
								$menu = $row['menu_id'];
								$price = $row['price'];
								$qty = $row['quantity'];
								$total = $price * $qty;
								$gtotal += $total;
								}
							}
						?>
						<tbody>
							<tr>
								
								<td><?php echo $order;?></td>
								<td><?php echo $menu;?></td>
								<td><?php echo "&#8369;" .$price;?></td>
								<td><?php echo $qty;?></td>
								<td><?php echo "&#8369;" .$total;?></td>
								<td>
									<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										
									</button>
										<div class="dropdown-menu">
										<a data-toggle="modal" data-target="#exampleModalCenter1" class="dropdown-item">Add New Order</a>
										<a class="dropdown-item" href="order.php?editorder=<?php echo $row['order_id']; ?>">Edit</a>
										<a class="dropdown-item" href="process2.php?delete_order=<?php echo $row["hide_id"]; ?>" onclick="return confirm('Are you sure?');">Delete</a>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-sm-5" style="border-style: solid">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<tr>
							<th>Order ID</th>
							<th>Customer ID</th>
							<th>Timestamp</th>
							<th>Action</th>
							</tr>
						</thead>
						<?php while($row = mysqli_fetch_array($search_result)):?>
						<tbody>
							<tr>
								<td><?php echo $row['order_id'];?></td>
								<td><?php echo $row['customer_id'];?></td>
								<td><?php echo $row['timestamp'];?></td>
								<td>
									<div class="btn-group">
									<button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										
									</button>
										<div class="dropdown-menu">
										<a data-toggle="modal" data-target="#exampleModalCenter1" class="dropdown-item">Add New Order</a>
										<a class="dropdown-item" href="order.php?editorder=<?php echo $row['order_id']; ?>">Edit</a>
										<a class="dropdown-item" href="process1.php?delete_id=<?php echo $row["order_id"]; ?>" onclick="return confirm('Are you sure?');">Delete</a>
										</div>
									</div>
								</td>
							</tr>
						</tbody>
						<?php endwhile;?>
					</table>
				</div>
			</div>
		</div>
      </body>
	  <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="form-control" style="width: 1200px">
					<div class="modal-content modal-lg">
						<div class="modal-header">
							<h5 class="modal-title" >Add New Order</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
							
							<form action="process1.php" method="post">
								
								<label class="col-form-label">Order ID:</label>
								<input type="text" class="form-control form-control-sm" name="order_id" placeholder="Order Id" value="" required>
								<label class="col-form-label">Customer Name:</label>
								<select name="customer_id" class="form-control" required>
									<?php while($row = mysqli_fetch_array($query_cus)):?>
										<option value="<?php echo $row['customer_id'];?>"><?php echo $row['first_name'];?></option>
									<?php endwhile;?>
								</select>
								<label class="col-form-label">Timestamp:</label>
								<input type="datetime-local" class="form-control form-control-sm" name="timestamp" placeholder="timestamp" value="<?php echo $timestamp;?>" required>
								<input class="btn btn-primary btn-block button2" type="submit" name="add" value="Save" onclick="return confirm('Are you sure?');">
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="form-control" style="width: 1200px">
					<div class="modal-content modal-lg">
						<div class="modal-header">
							<h5 class="modal-title" >Update Order</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
						</div>
						<div class="modal-body">
							<?php require_once 'process1.php'; ?>
							<form action="process1.php" method="post">
								<input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
								<label class="col-form-label">Order ID:</label>
								<input type="text" class="form-control form-control-sm" name="order_id" placeholder="Order Id" value="<?php echo $order_id; ?>" required>
								<label class="col-form-label">Customer Name:</label>
								<select name="customer_id" class="form-control" value="<?php echo $order_id; ?>" required>
									<?php
										$con = new mysqli('localhost', 'root', '', 'kusina1') or die(mysqli($mysqli));
										$sql = "SELECT * FROM customer";
										$query_cus = mysqli_query($con,$sql);
									?>
									<?php while($row = mysqli_fetch_array($query_cus)):?>
										<option value="<?php echo $row['customer_id'];?>"><?php echo $row['first_name'];?></option>
									<?php endwhile;?>
								</select>
								<label class="col-form-label">Timestamp:</label>
								<input type="datetime-local" class="form-control form-control-sm" name="timestamp" placeholder="timestamp" value="<?php echo $timestamp;?>" required>
								<?php
									if ($update2 == true):
									echo "<script>$('#modal2').modal('show');</script>";
								?>
									<input class="btn btn-primary btn-block button2" type="submit" name="updateorder" value="Update" onclick="return confirm('Are you sure?');">
								<?php else: ?>
									<input class="btn btn-primary btn-block button2" type="submit" name="add" value="Add" onclick="return confirm('Are you sure?');">
								<?php endif;?>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
</html>