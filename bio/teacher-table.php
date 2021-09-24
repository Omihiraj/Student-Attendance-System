<?php 
 session_start(); 


?>
<?php require_once('connectDB.php');  ?>

<?php

	$user_list = ''; 
	$st_time = $_SESSION['time'];

	if($_SESSION['status'] == 1){
		
		
		 $query = "SELECT * FROM log_data WHERE login_time > STR_TO_DATE('$st_time', '%Y-%m-%d %h:%i:%s')";
         $result_set = mysqli_query($conn,$query);
        if($result_set){
        			
        		while($row = mysqli_fetch_assoc($result_set)) {
        			
        			
        			$user_list .= "<tr>";
        			$user_list .= "<td></td>";
                    $user_list .= "<td>{$row['index_no']}</td>";
                    $user_list .= "<td>{$row['name']}</td>";
                    $user_list .= "<td>{$row['login_time']}</td>";
                    $user_list .= "</tr>";
                }
                echo "<table>";
                echo $user_list;
                echo "</table>";
        }	
        else{
        	echo "Not yet student logging.......";
        }

	}


 ?>