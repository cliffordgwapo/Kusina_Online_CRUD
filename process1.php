<?php

	$mysqli = new mysqli('localhost', 'root', '', 'kusina') or die(mysqli($mysqli));
	
	$menu_id = 0;
	$customer_id = 0;
	$update = false;
	$update1 = false;
	$first_name = '';
	$last_name = '';
	$middle_initial = '';
	$phone_number = '';
	$province = '';
	$street = '';
	$barangay = '';
	$city = '';
	$order_id = '';
	$timestamp = '';
	
	if (isset($_POST['submit'])) {
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$middle_initial = $_POST['middle_initial'];
		$phone_number = $_POST['phone_number'];
		$province = $_POST['province'];
		$street = $_POST['street'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
		
		$mysqli->query("INSERT INTO customer (first_name, last_name, middle_initial, phone_number, province, street, barangay, city) VALUES('$first_name', '$last_name', '$middle_initial', '$phone_number', '$province', '$street', '$barangay', '$city')") or die($mysqli->error);
		header("location: customer.php");
	}
	if (isset($_GET['delete'])) {
		$customer_id = $_GET['delete'];
		$mysqli->query("DELETE FROM customer WHERE customer_id=$customer_id") or die($mysqli->error());
		header("location: customer.php");
	}
	if (isset($_GET['edit'])) {
		$customer_id = $_GET['edit'];
		$update = true;
		$result = $mysqli->query("SELECT * FROM customer WHERE customer_id=$customer_id") or die($mysqli->error());
		if (@count($result)==1) {
			$row = $result->fetch_array();
			$customer_id = $row['customer_id'];
			$first_name = $row['first_name'];
			$last_name = $row['last_name'];
			$middle_initial = $row['middle_initial'];
			$phone_number = $row['phone_number'];
			$province = $row['province'];
			$street = $row['street'];
			$barangay = $row['barangay'];
			$city = $row['city'];
		}
	}
	if (isset($_POST['update'])) {
		$customer_id = $_POST['customer_id'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$middle_initial = $_POST['middle_initial'];
		$phone_number = $_POST['phone_number'];
		$province = $_POST['province'];
		$street = $_POST['street'];
		$barangay = $_POST['barangay'];
		$city = $_POST['city'];
		
		$mysqli->query("UPDATE customer SET customer_id='$customer_id', first_name='$first_name', last_name='$last_name', middle_initial='$middle_initial', phone_number='$phone_number', province='$province', street='$street', barangay='$barangay', city='$city' WHERE customer_id=$customer_id") or die($mysqli->error);
		header("location: customer.php");
	}
	if (isset($_POST['add'])) {
		$order_id = $_POST['order_id'];
		$customer_id = $_POST['customer_id'];
		$timestamp = $_POST['timestamp'];
		
		$mysqli->query("INSERT INTO customer_order (order_id, customer_id, timestamp) VALUES('$order_id', '$customer_id', '$timestamp')") or die($mysqli->error);
		header("location: order.php");
	}
	if (isset($_GET['deletemenu'])) {
		$menu_id = $_GET['deletemenu'];
		$mysqli->query("DELETE FROM customer WHERE menu_id=$menu_id") or die($mysqli->error());
		header("location: customer.php");
	}
	if (isset($_GET['editmenu'])) {
		$menu_id = $_GET['editmenu'];
		$update1 = true;
		$result = $mysqli->query("SELECT * FROM menu WHERE menu_id=$menu_id") or die($mysqli->error());
		if (@count($result)==1) {
			$row = $result->fetch_array();
			$menu_id = $row['menu_id'];
			$menu_name = $row['menu_name'];
			$menu_description = $row['menu_description'];
			$price = $row['price'];
			$unit = $row['unit'];
			$image = $row['image'];
		}
	}
	if (isset($_POST['updatemenu'])) {
		$menu_id = $_POST['menu_id'];
		$menu_name = $_POST['menu_name'];
		$menu_description = $_POST['menu_description'];
		$price = $_POST['price'];
		$unit = $_POST['unit'];
		$image = $_POST['image'];
		
		$mysqli->query("UPDATE menu SET menu_id='$menu_id', menu_name='$menu_name', menu_description='$menu_description', price='$price', unit='$unit' WHERE menu_id=$menu_id") or die($mysqli->error);
		header("location: menu.php");
	}
?>