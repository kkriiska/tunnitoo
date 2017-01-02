<?php

	require("../../config.php");
	
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	$signupEmailError="";
	$signupEmail = "";
	
	//kas on olemas
	if (isset ($_POST["signupEmail"])) {
		//oli olemas
		//tuhi?
		if (empty ($_POST["signupEmail"])) {
			//oli tuhi
			$signupEmailError = "See väli on kohustuslik";
		} else {
			//koik ok
			$signupEmail = $_POST["signupEmail"];
		}
	}
	
	$signupPasswordError = "";
	
	//kas olemas
	if (isset ($_POST["signupPassword"])) {
		//oli olemas
		//kas tuhi?
		if (empty ($_POST["signupPassword"])) {
			//oli tuhi
			$signupPasswordError = "See väli on kohustuslik";
		} else {
			//midagi oli
			//kas ikka 8tm pikk?
			if (strlen ($_POST["signupPassword"]) < 8 ) {
				$signupPasswordError = "Parool peab olema vähemalt 8 tahemarki pikk";
			}
		}
	}
	
	$gender = "";
	if(isset($_POST["gender"])) {
		if(!empty($_POST["gender"])){
			//on olemas
			$gender = $_POST["gender"];
		}
	}
	
	if ( isset($_POST["signupEmail"]) && isset($_POST["signupPassword"]) && $signupEmailError == "" && empty($signupPasswordError)) {
		//vigu pole, koik ok
		echo "salvestan...<br>";
		echo "email ".$signupEmail."<br>";
		echo "parool ".$_POST["signupPassword"]."<br>";
			
		$password = hash("sha512", $_POST["signupPassword"]);

		echo "räsi ".$password."<br>";
		
		//uhendus
		$database = "if16_karokrii"
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
		
		//kask
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		echo $mysqli->error;
		
		// s - string
		// i - int
		// d - decimal/double
		//iga küsimärgi jaoks üks täht, mis tüüpi on
		$stmt->bind_param("ss", $signupEmail, $password );
		
		//taida kasku
		if ( $stmt->execute() ) {
			echo "salvestamine õnnestus";
		} else {
			echo "ERROR ".$stmt->error;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sisselogimise leht</title>
	</head>
	<body>
		<h1>Logi sisse</h1>
		<form method="POST">
			<label>E-post</label><br>
			<input name="loginEmail" type="email">
			
			<br><br>
			
			<label>Parool</label><br>
			<input name="loginPassword" type="password">
			
			<br><br>
			
			<input type="submit" value="Logi sisse">
			
		</form>
		<h1>Loo kasutaja</h1>
		<form method="POST">
			
			<input placeholder="E-mail" name="signupEmail" type="email"> <?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input placeholder="Parool" name="signupPassword" type="password">
			
			<br><br>
			
			<?php if ($gender == "male") { ?>
				<input type="radio" name="gender" value="male" checked > Mees<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="male"> Mees<br>
			<?php } ?>
			
			<?php if ($gender == "female") { ?>
				<input type="radio" name="gender" value="female" checked > Naine<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="female"> Naine<br>
			<?php } ?>
			
			<?php if ($gender == "other") { ?>
				<input type="radio" name="gender" value="other" checked > Muu<br>
			<?php } else { ?>
				<input type="radio" name="gender" value="other"> Muu<br>
			<?php } ?>
			
			<input type="submit" value="Loo kasutaja">
			
			</form>
	</body>
</html>
			