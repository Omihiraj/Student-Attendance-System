<?php 
	session_start();
 ?>
<?php require_once('connectDB.php');  ?>
<?php 
	$errors = array();

	


		if(isset($_POST['user_add'])){

			$req_feilds = array('name','number','department','tpno');

			foreach ($req_feilds as $feild) {
				if(empty(trim($_POST[$feild]))){
					$errors[] = $feild." is required !"; 
				}	
			}
			if(empty($errors)){
				$name = mysqli_real_escape_string($conn,$_POST['name']);
				$number = mysqli_real_escape_string($conn,$_POST['number']);
				$department = mysqli_real_escape_string($conn,$_POST['department']);
				$tpno = mysqli_real_escape_string($conn,$_POST['tpno']);

				$sql = "SELECT * FROM user WHERE mobile_no = 0 LIMIT 1";
				$result = mysqli_query($conn,$sql);
				if($result){
					if (mysqli_num_rows($result) == 1) {
						$query = "UPDATE user SET name='$name',index_no='$number',department='$department',mobile_no = '$tpno'  WHERE mobile_no = 0";
						$sql2 = "UPDATE switch set add_finger = 0 WHERE add_finger = 1";
						$result = mysqli_query($conn, $sql2);
						$result_set = mysqli_query($conn,$query);
						if($result_set){
							echo"success";
						}
						else{
							echo"unsuccess";
						}


					}
					
				}
				else{
					echo("Please Enter Finger ID First !.......");
				}

				
			}
		
		
		
		}
		
	

	
 ?>
<?php
	$_SESSION['add-finger'] = 100;
	$GLOBALS['finger_Id'] = 1;
	
	if(isset($_POST['fingerid_btn'])){

		$_SESSION['add-finger'] = 1;
		$alert = array();
		if(empty($_POST['finger_id'])){
			$errors[] = 'Fingerprint Missing'; 

		}

		if(empty($errors)){

			$finger_Id = mysqli_real_escape_string($conn,$_POST['finger_id']);
			$query = "SELECT * FROM user WHERE finger_id = '{$finger_Id}' LIMIT 1 ";
			$result = mysqli_query($conn,$query);
			

			if($result){
				
				if(mysqli_num_rows($result) == 1){
					$errors[] = "Exist Value";
					show_alert(1);
					
				}
			}
			if(empty($errors)){

				$query = "SELECT * FROM user WHERE mobile_no  = 0 LIMIT 1";
				$result = mysqli_query($conn,$query);
				if($result){

					if(!mysqli_num_rows($result) == 1){

						$row = mysqli_fetch_assoc($result);
						

						$sql = "INSERT INTO user (finger_id) VALUES ('$finger_Id')";
						$sql2 = "UPDATE switch set add_finger = 1 WHERE add_finger = 0";
						$result = mysqli_query($conn, $sql2);
						$result_set = mysqli_query($conn, $sql);
				
				
						if ($result_set){
  							//show_alert(2);

						} 
						else{
  							show_alert(3);
  							$errors[] = "Error";
						}

					}
					else{
						show_alert(4);


					}

				}
				
				
									
			}
			
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Daily Attendance System</title>
    <link href="css/addstudent.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    
</head>
<body>
	<p id="test"></p>
	
	
				<?php
					function show_alert($i){
						$val = $i;
						if($val==1){
							echo'<div class="errmsg">Already in the Database Please Select Another Value</div>';
						}
						elseif($val==2){
							echo'<div class="errmsg">Data Insert Succesfully</div>';
						}
						elseif ($val==3) {
							echo'<div class="errmsg">Error</div>';
							
						}
						elseif($val==4){
							echo'<div class="errmsg">Please Enter User Info For User Finger Id</div>';
						}
					}
					  ?>
					  <?php
					  	if(!empty($errors)){
					  		echo '<div class="errmsg">';
					  		echo '<b>There were errors on your form</b></br>';
					  		foreach ($errors as $error) {
					  			echo $error.'<br>';
					  		}
					  		echo '</div>';
					  	}
					   ?>
	<div class="container">
        <div id="cover">
            <h1 class="sign-up">Welcome !..</h1>
            <p class="sign-up">First Insert Finger Id<br>Then Click Next Button</p>
            <a class="button sign-up" href="#cover">Next</a>
            <h1 class="sign-in">Welcome Back!</h1>
            <p class="sign-in">Now You Can Enter<br>Student's Personal Info</p>
                
            <br>

            <a class="button sub sign-in" href="#">previous</a>
        </div>

        <div class="login">

            <h1>Student Registration</h1>
            
            <span class="social-login"><img src="fingerprints.png" height="100px" width="100px"></span>
            <p>Enter Fingerprint ID between 1 & 127</p>
            
                            

            <form action="addstudent.php" method="POST">
                <input type="number" name="finger_id" id="finger_id" placeholder="Student Finger Id..." class="input-field" min="1" max="127" required="Please add fingerprint" ><br>
                
                <input name="fingerid_btn" type="submit" value="Submit" class="submit-btn">
            </form>
        </div>

        <div class="register">
            <h1>Student Information</h1>
            <span class="social-login"><img src="student.png" height="100px" width="100px"></span>
            
                            
            <form action="addstudent.php" method="POST">
                <input name="name" id="name" type="text" placeholder="Student Name..." class="input-field" required="Please Enter User Name"><br>

                <input type="text" name="number" id="number" placeholder="Index No..." class="input-field" required="Please Enter Index No"><br>

                <input type="text" name="department" id="nic" placeholder="Department..." class="input-field" required="Please Department Name"><br>

                <input type="text" name="tpno" id="tpno" placeholder="Mobile No..." class="input-field" required="Please Enter Mobile Number"><br>

                <input class="submit-btn" name="user_add" type="submit" value="Submit" >
            </form>
        </div>
    </div>				
					
				
				
			
		
	

</body>
</html>
 
<?php mysqli_close($conn);?>