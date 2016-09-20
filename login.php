<?php
	require("../../../config.php");
	//echo hash("sha512", "Romil");

	//GET ja POSTI muutujad
	//var_dump($_POST);
	//echo "<br>";
	//var_dump ($_GET);
	
	//MUUTUJAD
	$signupEmailError= "";
	$signupEmail = "";
	
	
	//$_post["signupEmail"];
	
	if(isset($_POST["signupEmail"])) {
		
		//jah on olemas
		//kas on tühi
		if(empty($_POST["signupEmail"])) {
			
			$signupEmailError="See väli on kohustuslik";
		} else {
			
			$signupEmail = $_POST["signupEmail"];
			
		}
	}
	
	$signupPasswordError= "";
	
	if(isset($_POST["signupPassword"])) {
		
		if(empty($_POST["signupPassword"])) {
			
			$signupPasswordError="Parool on kohustuslik";
			
		}else{
			
			//siia jõuan siis kui parool oli olemas -isset
			//ja parool ei olnud tühi -empty
			//kas parooli pikkus on väiksem kui 8
			if(strlen($_POST["signupPassword"]) <8){
				
				$signupPasswordError="Parool peab olema vähemalt 8 tähemärki pikk!";
				
			}
			
		}
		
	
		
		
		
	}
	
	$eesnimierror= "";
	
   if(isset($_POST["Eesnimi"])) {
		
		
		if(empty($_POST["Eesnimi"])) {
			
			$eesnimierror="See väli on kohustuslik";
		}
	}
	
	$Perenimierror= "";
	
	if(isset($_POST["Perenimi"])) {
		
		
		if(empty($_POST["Perenimi"])) {
			
			$Perenimierror="See väli on kohustuslik";
		}
	}
	
	$Aadresserror= "";
	
	if(isset($_POST["aadress"])) {
		
		
		if(empty($_POST["aadress"])) {
			
			$Aadresserror="See väli on kohustuslik";
		}
	}
	
	
	// peab olema email ja parool
	// ühtegi errorit
	
		if ( isset($_POST["signupPassword"]) &&
		isset($_POST["signupEmail"]) &&
		$signupEmailError == "" &&
		empty($signupPasswordError)
		
	
		

		) {
		
		//salvestame andmebaasi
		echo "email: ".$signupEmail."<br>";
		
		echo "password: ".$_POST["signupPassword"]."<br>";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
	
		//echo $serverUsername;
		
		//Ühendus
		$database = "if16_StenT_2";
		$mysqli = new mysqli($serverHost, $serverUsername, $serverPassword, $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		
		// stringina üks täht iga muutuja kohta, mis tüüp (?)
		// string - s
		// integer - i
		// float (double) - d
		// küsimargid asendada muutujaga
		$stmt->bind_param("ss", $signupEmail, $password);
		
		//täida käsku
		
		if ($stmt->execute()) {
			
			echo "salvestamine õnnestus";
		} else {
			
			echo "ERROR".$stmt->error;
		}
		
		//panen ühenduse kinni
		
		$stmt->close();
		$mysqli->close();



	}
	
	
	
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logi sisse või loo kasutaja</title>
</head>
<body>

	<h1>Logi sisse </h1>
	<form method="POST">
		<label>E-post</label>
		<br>
		
		<input name="loginEmail" type="text">
		<br><br>
		
		<input name="loginPassword" placeholder="parool" type="password">
		<br><br>
		
		<input type="submit" value="Logi sisse">
		
	</form>
	
	
	<h1>Loo kasutaja </h1>
	<form method="POST">
		
		
		<input name="signupEmail" placeholder="E-post "type="text" value="<?=$signupEmail;?>"> <?php echo $signupEmailError; ?>
		<br><br>
		
		<input name="signupPassword" placeholder="parool" type="password"> <?php echo $signupPasswordError; ?>
		<br><br>
		
		<input name="Eesnimi" placeholder="Sisestage eesnimi" type="text"> <?php echo $eesnimierror; ?>
		<br><br>
		
		<input name="Perenimi" placeholder="Sisestage Perekonnanimi" type="text"> <?php echo $Perenimierror; ?>
		<br><br>
		
		<input name="Aadress" placeholder="Sisestage aadress" type="text"> <?=$Aadresserror; ?>
		<br><br>
		
		
		<input type="submit" value="Loo kasutaja">
		

		
	</form>
	
	
	
	
	
</body>
</html>