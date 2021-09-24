
<?php 
session_start(); 


?>
<?php 
	require_once('connectDB.php');
	//require_once('teacher-table.php');  

?>


<?php
	//$teacher_id = mysqli_real_escape_string($conn,$_SESSION['teacher_id']);
	$teacher_id = 1;
	$query = "SELECT * FROM subject_data WHERE teacher_id = '$teacher_id' ";
	$result = mysqli_query($conn,$query);
	$subject_codes = "";
	if($result){
		if(mysqli_num_rows($result)>0){
			while($code = mysqli_fetch_assoc($result)){
				
				$subject_codes .= "<option value = \"{$code['subject_code']}\">{$code['subject_name']}</option>";
			}
			

				
		}
		else{
			echo "no rows";
		}
		
	}
	else{
		echo"Erorrrr";
	}
	
	
?>

<?php
	
	$_SESSION['status'] = 100;
	

	$start_time =  date("Y-m-d h:i:s");

	if (isset($_POST['start'])) {
		$_SESSION['status'] = 1;
		$_SESSION['sub_code'] = $_POST['selector'];
		$query = "UPDATE switch SET lesson = 1 WHERE lesson = 0 ";
		$result = mysqli_query($conn,$query);
		
		date_default_timezone_set("Asia/Colombo");
		$start_time = date("Y-m-d h:i:s");

	}
	$_SESSION['time'] = $start_time;
	
	if(isset($_POST['finish'])){
		$_SESSION['status'] = 0;
		$sql = "UPDATE switch SET lesson = 0 WHERE lesson = 1 ";
		$result = mysqli_query($conn,$sql);
	}




	
	
	//$start_time;
	

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<style>
		table {
		  border-collapse: collapse;
		  width: 80%;
		  float:center
		  margin-right:100px;
		}

		th, td {
		  text-align: left;
		  padding: 8px;
		}

		tr:nth-child(even){background-color: #f2f2f2}

		th {
		  background-color: #668cff;
		  color: white;
		}




		input[type=text] {
		  width: 150px;
		  box-sizing: border-box;
		  border: 2px solid #ccc;
		  border-radius: 4px;
		  font-size: 16px;
		  background-color: white;
		  
		  background-position: 10px 10px; 
		  background-repeat: no-repeat;
		  padding: 12px 20px 12px 40px;
		  -webkit-transition: width 0.4s ease-in-out;
		  transition: width 0.4s ease-in-out;
		}

		input[type=text]:focus {
		  width: 80%;
		}



		a:link, a:visited {
		  background-color: #f44336;
		  color: white;
		  padding: 6px 25px;
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  border-radius: 50px;
		  margin-left: 10px
		}

		a:hover, a:active {
		  background-color: red;
		  box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24),0 17px 50px 0 rgba(0,0,0,0.19);
		}
		.refresh {
		  background-color: #4d94ff; 
		  border: none;
		  border-radius: 100px;
		  color: white;
		  padding: 7px 16px;````````````````````````````````````
		  text-align: center;
		  text-decoration: none;
		  display: inline-block;
		  font-size: 8px;
		  margin: 2px 1px;
		  cursor: pointer;
		  -webkit-transition-duration: 0.4s; 
		  transition-duration: 0.4s;
		}
		
	</style>
	
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/select.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	

	
	<!---<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/select.js"></script>

	<script>	

		$(document).ready(function(){
			
		  function myfun(){
		  	$.get("teacher-table.php", function(data, status){
			   $("#table-data").html(data);
			  });
		  }
		  $(".refresh").click(function(){
		   setInterval(function(){myfun(); }, 500);
		  });
		  

		  
		});



		$(document).ready(function(){
		  $("#myInput").on("keyup", function() {
		    var value = $(this).val().toLowerCase();
		    $("#table-data tr").filter(function() {
		      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		    });
		  });
		});
			
	</script>
</head>
<body>
	<header>
		<div class ="appname" style="float: left";>Fingerprint Attendance System</div>
		<div class="loggedin"  style="float: right"; >Wellcome Username!
			<div style="float: right"><a href="logout.php">Log Out</a></div>

		</div>
		
	</header>
	

	<div class = "up">
		<div style="float: left";>
		<form action="teacher-view.php" method="post">
			<button  name="start" id="start" class="button button1" >Start Lesson</button>
		
		</div>

		

		<div style="float: right"; >
			
				<button id="finish" name = "finish" class="button button2">Finish Lesson</button>
			
		</div>

		<div  id="slc" class="custom-select" style="width:40%;">
			<select name="selector" id="scd">
				<option value="0">Select Subject :</option>
				<?php echo $subject_codes; ?>
			</select>
		</div>
		</form>
	
	</div>	
		
	<div align="center">
		
 		<input type="text" name="search" id = "myInput" placeholder="Search..">
		
	</div>	
	<br>
		
	<div align="center">
			
		<table>
			<tr>
				
			</tr>
		</table>	
		<br>
		<table>
			
			<thead>
				<tr>
				<th width="75"> <button class="refresh"  style="font-size:12px" onclick="myFunction()"><i class="fa fa-refresh fa-spin" style="font-size:18px" ></i></button> </th>
				<th>Index No</th>
				<th>Name</th>
				<th>Login Time</th>
				</tr>
				
			</thead>

			<tbody id="table-data">
				
			</tbody>
			

			
		</table>
		
		
		 
	</div>

	


<script>
var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select");
l = x.length;
for (i = 0; i < l; i++) {
  selElmnt = x[i].getElementsByTagName("select")[0];
  ll = selElmnt.length;
  /*for each element, create a new DIV that will act as the selected item:*/
  a = document.createElement("DIV");
  a.setAttribute("class", "select-selected");
  a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
  x[i].appendChild(a);
  /*for each element, create a new DIV that will contain the option list:*/
  b = document.createElement("DIV");
  b.setAttribute("class", "select-items select-hide");
  for (j = 1; j < ll; j++) {
    /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
    c = document.createElement("DIV");
    c.innerHTML = selElmnt.options[j].innerHTML;
    c.addEventListener("click", function(e) {
        /*when an item is clicked, update the original select box,
        and the selected item:*/
        var y, i, k, s, h, sl, yl;
        s = this.parentNode.parentNode.getElementsByTagName("select")[0];
        sl = s.length;
        h = this.parentNode.previousSibling;
        for (i = 0; i < sl; i++) {
          if (s.options[i].innerHTML == this.innerHTML) {
            s.selectedIndex = i;
            h.innerHTML = this.innerHTML;
            y = this.parentNode.getElementsByClassName("same-as-selected");
            yl = y.length;
            for (k = 0; k < yl; k++) {
              y[k].removeAttribute("class");
            }
            this.setAttribute("class", "same-as-selected");
            break;
          }
        }
        h.click();
    });
    b.appendChild(c);
  }
  x[i].appendChild(b);
  a.addEventListener("click", function(e) {
      /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
      e.stopPropagation();
      closeAllSelect(this);
      this.nextSibling.classList.toggle("select-hide");
      this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
  /*a function that will close all select boxes in the document,
  except the current select box:*/
  var x, y, i, xl, yl, arrNo = [];
  x = document.getElementsByClassName("select-items");
  y = document.getElementsByClassName("select-selected");
  xl = x.length;
  yl = y.length;
  for (i = 0; i < yl; i++) {
    if (elmnt == y[i]) {
      arrNo.push(i)
    } else {
      y[i].classList.remove("select-arrow-active");
    }
  }
  for (i = 0; i < xl; i++) {
    if (arrNo.indexOf(i)) {
      x[i].classList.add("select-hide");
    }
  }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
</script>	

</body>
</html>

