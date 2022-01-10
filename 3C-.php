<?php
$db_link = mysqli_connect("localhost", "root", "0831","web期末");
mysqli_query($db_link, "SET NAMES 'utf8'");	//設定連線的文字集與校對為 UTF8 編碼
if(isset($_POST["reserve"])){
	$sql="SELECT `num`, `sequence` FROM `3c預購-排隊系統` WHERE `state`='正常'";
	$result=mysqli_query($db_link, $sql);
	$rownum=mysqli_num_rows($result);
	$rownum=$rownum+1;
	$identity=$_POST["identity"];
	$phone=$_POST["phone"];
	$sql="INSERT INTO `3c預購-排隊系統`(`identity`, `phone`,`sequence`) VALUE('$identity','$phone', '$rownum')";
	$result=mysqli_query($db_link, $sql);

	echo "<script type='text/javascript'>alert('預購成功');</script>";
}
if(isset($_POST["cancelreserve"])){
	$identity=$_POST["identity"];
	$phone=$_POST["phone"];
	$sql="SELECT * FROM `3c預購-排隊系統` WHERE `identity`='$identity'";
	$result=mysqli_query($db_link, $sql);
	$row = mysqli_fetch_assoc($result);
	$num=$row["num"];
	$sql="UPDATE `3c預購-排隊系統` SET `state`='cancel', `sequence`='0' WHERE `identity`='". $row["identity"]. "'";
	$result=mysqli_query($db_link, $sql);
	
	$sql="SELECT * FROM `3c預購-排隊系統` WHERE `state`='正常'";
	$result=mysqli_query($db_link, $sql);
	while($row = mysqli_fetch_assoc($result)){
		if($row["num"]>$num){
		$sequence=$row["sequence"]-1;
		$sql="UPDATE `3c預購-排隊系統` SET `sequence`=".$sequence . "WHERE `num`=". $row["num"];
		mysqli_query($db_link, $sql);
		}
	}
	echo "<script type='text/javascript'>alert('預購已取消');</script>";
}?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<meta http-equiv="Content-Language" content="zh-tw" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>


<body>

<?php if(!isset($_POST["identity"])){ ?>
<h1><div class="container-sm">預購資料</div></h1>
<form action="" method="post">
<div class="container">
	<div class="form-floating mb-3">
		<input type="text" class="form-control" id="identity" name="identity">
		<label for="floatingInput">真實性名</label>
	</div>
</div>
<div class="container custom-container">
<div class="form-floating">
  <input type="text" class="form-control" id="phone" name="phone">
  <label for="floatingPassword">手機號碼</label>
</div>
</div><br/>
<div class="container custom-container">
<button type="submit" class="btn btn-primary">登入</button>
</div>
</form>
<?php } ?>

<?php
$db_link = mysqli_connect("localhost", "root", "0831","web期末");
mysqli_query($db_link, "SET NAMES 'utf8'");	//設定連線的文字集與校對為 UTF8 編碼


if(isset($_POST["identity"])){
	$sql="SELECT `identity` FROM `3c預購-排隊系統` WHERE `state`='正常' AND `identity`='".  $_POST["identity"] ."'" ;
	$result=mysqli_query($db_link, $sql);
	$rownum=mysqli_num_rows($result); 
	?>
	<?php if($rownum==0){#無預購資料 ?>
	<h1><div class="container-sm">預購資料</div></h1>
	<div class="container">
	<div class="form-floating mb-3">
		<input type="text" class="form-control"  aria-label="Disabled input example"  id="identity" disabled>
		<label for="floatingInput">真實性名</label>
	</div>
	</div>
	<div class="container-sm">
		<div class="form-floating">
			<input type="text" class="form-control" id="phone" name="phone" disabled>
			<label for="floatingPassword">手機號碼</label>
		</div>
	</div><br/>
		<form action="" method="post">
		<input type="hidden" name="identity" value=<?php echo $_POST["identity"] ?>>
		<input type="hidden" name="phone" value=<?php echo $_POST["phone"] ?>>
		<input type="hidden" name="reserve">
		<button type="submit" class="btn btn-primary">預購</button>
		</form>
		
	<?php }else{ #有預購資料 ?>
	<h1><div class="container-sm">預購資料</div></h1>
	<div class="container">
		<div class="form-floating mb-3">
			<input type="text" class="form-control"  aria-label="Disabled input example"  id="identity" disabled>
			<label for="floatingInput">真實性名</label>
		</div>
	</div>
	<div class="container-sm">
		<div class="form-floating">
			<input type="text" class="form-control" id="phone" name="phone" disabled>
			<label for="floatingPassword">手機號碼</label>
		</div>
	</div><br/>
	<form action="" method="post">
		<input type="hidden" name="identity" value=<?php echo $_POST["identity"] ?>>
		<input type="hidden" name="phone" value=<?php echo $_POST["phone"] ?>>
		<input type="hidden" name="cancelreserve">
		<button type="submit" class="btn btn-primary">取消預購</button>
	</form>	
<?php }} ?>




<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
	 $(document).ready(function () { 
		let identity = JSON.parse(window.localStorage.getItem('identity'));
		let phone = JSON.parse(window.localStorage.getItem('phone'));
		if (!!identity) {
		$("#identity").val(identity);
		}
		if (!!phone) {
		$("#phone").val(phone);
		}
	});
	
	$("#identity").keyup(function (){
		let identity= $("#identity").val() ;
		window.localStorage.setItem('identity', JSON.stringify(identity));

	});
	$("#phone").keyup(function (){
		let phone= $("#phone").val() ;
		window.localStorage.setItem('phone', JSON.stringify(phone));
	});
	</script>

	</body>
</html>