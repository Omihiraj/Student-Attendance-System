<?php 
//******************************** SESSION START *****************************************************************
  session_start();  
?>
<?php
//******************************** CONNECT WITH DATA BASE **********************************************************
 require_once('connectDB.php');
 

 ?>
<?php
    date_default_timezone_set("Asia/Colombo");

    $subject_code = "CO1221"; 

     
    if(!empty($_POST['confirm_id'])){
       
        $log = 2;
        $add = 2;

        $status = $_POST['confirm_id'];
        $query = "SELECT lesson FROM switch ";
        $result = mysqli_query($conn,$query);
        if($result){
            if (mysqli_num_rows($result) == 1) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    $log = $row['lesson'];
                }
            }else{
                echo "noo";
            }
            
        }
        if($log==1){
            echo"log_in";
        }

        $query = "SELECT add_finger FROM switch ";
        $result = mysqli_query($conn,$query);
        if($result){
            if (mysqli_num_rows($result) == 1) {
                
                while($row = mysqli_fetch_assoc($result)) {
                    $add = $row['add_finger'];
                    $log = 0;
                }
            }else{
                echo "noo";
            }
            
        }


       if ($add==1) {
            $sql = "SELECT finger_id FROM user WHERE mobile_no = 0";
            $result = mysqli_query($conn, $sql);


        if ($result == TRUE) {

            if (mysqli_num_rows($result) == 1) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "set_id".$row["finger_id"];
                }
            } 
            else{
                echo "0 results";
            }
           
           //echo "OK";
           
        } 
        else {
            echo "Error";
        }
        }
        
        
    }


    if(!empty($_POST['FingerID'])){
       

        $status = $_POST['FingerID'];
        $sql = "SELECT name,index_no FROM user WHERE finger_id = $status LIMIT 1 ";
        $result = mysqli_query($conn, $sql);
        

        $indexno = "";
        $name = "";
        $date = "";
        

        if ($result) {

            if (mysqli_num_rows($result) == 1) {

                $date = date("Y-m-d h:i:s");

                while($row = mysqli_fetch_assoc($result)) {
                    echo "login".$row["name"];
                    $name = $row['name'];
                    $indexno = $row['index_no'];
                     

                }
                $query = "INSERT INTO log_data(index_no,name,subject_code,login_time) VALUES('$indexno','$name','$subject_code','$date')";
                $result_set = mysqli_query($conn, $query);
                if($result_set){
                    //echo"sucess";
                }
                else{
                    //echo mysqli_error($conn);
                }
            
           
            }
           
        }else {
            echo "Error";
        }
    }


    $conn->close();
?>