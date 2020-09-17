<?php
// define variables and set to empty values
$nameErr = $emailErr = $phoneErr = $messageErr = "";
$name = $email = $message = $phone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Le nom est requis.";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Seulement des lettres et des espaces sont autorisés pour le nom."; 
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Le mail est requis.";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Format du mail invalide."; 
    }
  }
    
  if (empty($_POST["phone"])) {
    $phone = "";
  } else {
    $phone = test_input($_POST["phone"]);

    if (!preg_match("/^[0-9]*$/",$phone)) {
      $phoneErr = "Format du numéro de téléphone invalide."; 
    }
  }

  if (empty($_POST["message"])) {
    $messageErr = "Merci de rédiger un message.";
  } else {
    $message = test_input($_POST["message"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($nameErr == "" and $emailErr == "" and $phoneErr == "" and $messageErr == "" and $name != "" and $email != "" and $message != ""){

	$mail = 'm2_13005@yahoo.fr'; // Déclaration de l'adresse de destination.
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	{
		$passage_ligne = "\r\n";
	}
	else
	{
		$passage_ligne = "\n";
	}
	//=====Déclaration des messages au format texte et au format HTML.
	$message_txt = 			
	"Nom : " . $name . $passage_ligne.
	"Mail : ". $email. $passage_ligne.
	"Téléphone : " . $phone . $passage_ligne.
	$message . $passage_ligne;


	$message_html = 
	"<html><head></head><body>".
	"<p> Nom : " . $name . "</p>".
	"<p> Mail : ". $email. "</p>".
	"<p> Téléphone : " . $phone . "</p>".
	"<p>" . $message . "</p>";
	"</body></html>";
	//==========
	
	//=====Création de la boundary
	$boundary = "-----=".md5(rand());
	//==========
	
	//=====Définition du sujet.
	$sujet = "demande de devis de " . $name;
	//=========
	 
	//=====Création du header de l'e-mail.
	$header = "From: \"m2renovationpeinture\"<devis@m2renovationpeinture.fr>".$passage_ligne;
	$header.= "Reply-to: \"m2renovationpeinture\" <devis@m2renovationpeinture.fr>".$passage_ligne;
	$header.= "MIME-Version: 1.0".$passage_ligne;
	$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	//==========
	
	//=====Création du message.
	$mailMessage = $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format texte.
	$mailMessage.= "Content-Type: text/plain; charset=UTF-8".$passage_ligne;
	$mailMessage.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$mailMessage.= $passage_ligne.$message_txt.$passage_ligne;
	//==========
	$mailMessage.= $passage_ligne."--".$boundary.$passage_ligne;
	//=====Ajout du message au format HTML
	$mailMessage.= "Content-Type: text/html; charset=UTF-8".$passage_ligne;
	$mailMessage.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	$mailMessage.= $passage_ligne.$message_html.$passage_ligne;
	//==========
	$mailMessage.= $passage_ligne."--".$boundary."--".$passage_ligne;
	$mailMessage.= $passage_ligne."--".$boundary."--".$passage_ligne;
	//==========
	 
	//=====Envoi de l'e-mail.
	mail('m2_13005@yahoo.fr',$sujet,$mailMessage,$header);
	mail('alexandredlsb@gmail.com',$sujet,$mailMessage,$header);
	//==========
	
	function Redirect($url, $permanent = false)
	{
		header('Location: ' . $url, true, $permanent ? 301 : 302);

		exit();
	}

	Redirect('devis.html', false);
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="../../favicon.ico">

		<title>Rénovations et peintures pour particuliers ou professionnelles</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"/></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"/></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"/></script>
		<!-- Custom styles for this template -->
		<link rel="stylesheet" href="style.css" />
		
		<style>
			.error {color: #FF0000;}
		</style>
	</head>
	
	<body>
		<div class="container">
			<div class="header clearfix">
				<nav>
					<h3 class="text-muted">M2 RENOVATIONS PEINTURES</h3>
					
					<ul class="nav nav-pills float-right">
						<li class="nav-item">
							<a class="nav-link" href="index.html">Accueil</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="presentation.html">Présentation</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="engagement.html">Engagement & Garanties</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="photos.html">Photos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="contact.html">Contact</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="devis.php">Demandes de devis</a>
						</li>
					</ul>
				</nav>
			</div>


			<h2>Demandes de devis :</h2>
			<p><span class="error">* obligatoire.</span></p>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

				<p>Votre nom :<span class="error">* <?php echo $nameErr;?></span></p>
				<input type="text" class="form-control" name="name" value="<?php echo $name;?>">
				
				<br><br>
				<p>Votre adresse E-mail :<span class="error">* <?php echo $emailErr;?></span></p>
				<input type="text" class="form-control" name="email" value="<?php echo $email;?>">
				
				<br><br>
				<p>Votre numéro de téléphone :<span class="error"><?php echo $phoneErr;?></span></p>
				<input type="text" class="form-control" name="phone" value="<?php echo $phone;?>">
				
				<br><br>
				<p>Contenu de votre message :<span class="error">* <?php echo $messageErr;?></span></p>
				<textarea name="message" class="form-control" rows="5"><?php echo $message;?></textarea>
				
				<br><br>
				<input type="submit" class="form-control" name="submit" value="Envoyer la demande">  
			</form>
			
			<footer class="footer">
			
				<h5>ASSURANCES</h5>
				
				<p>
				Nous sommes couverts pour l’ensemble de nos travaux par une assurance décennale.
				</p>
				
				<h5>DEVELOPPEMENT DURABLE</h5>
				
				<p>
				Le terme « élimination » des déchets s’entend au sens de l’article L.541-2, Alinéa 2 du code de l’environnement :
				</p>
				
				<p>
				« L’élimination des déchets comporte les opérations de collecte, transport, stockage, tri et traitement nécessaires à la récupération des éléments et matériaux réutilisables ou de l’énergie, ainsi qu’au dépôt ou au rejet dans le milieu naturel de tous autres produits dans des conditions propres à éviter les nuisances mentionnées à l’alinéa précédent. »
				</p>
				
				<p>
				L’élimination des déchets de chantier issus des Travaux est soumise à l’obligation de prévention, de rééducation et de valorisation prévue par le code de l’environnement.
				</p>
				
				<p>
				M2 a prévu la gestion des déchets suivant le schéma de principe énoncé ci-dessous :
				<ul>
					<li>Dispositions préparatoires : document dans lequel sont exposées les mesures générales que nous nous engageons à mettre en œuvre pour gérer les déchets</li>
					<li>Tableaux de classification des déchets</li>
				</ul>
				</p>
			
				<p><table class="table">
					<thead>
						<tr>
							<th width="33%">Déchets dangereux (DIS)</th>
							<th width="33%">Déchets banals (DIB)</th> 
							<th width="33%">Déchets inertes</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Emballages souillés</td>
							<td>Emballages de toute nature non souillés (1)</td> 
							<td>Matériaux naturels non souillés</td>
						</tr>
						<tr>
							<td>Certains bois traités</td>
							<td>Matières plastiques</td> 
							<td>Plâtre (2)</td>
						</tr>
						<tr>
							<td>Peinture et vernis</td>
							<td>Fibres végétales, animales, synthétiques</td> 
							<td></td>
						</tr>
						<tr>
							<td>Colles animales, végétales synthétiques</td>
							<td>Laine minérales</td> 
							<td></td>
						</tr>
						<tr>
							<td>Solvants</td>
							<td>Laitiers</td> 
							<td></td>
						</tr>
						<tr>
							<td>Diluants</td>
							<td>Verre</td> 
							<td></td>
						</tr>
						<tr>
							<td>Mastics</td>
							<td>Bois non traités</td> 
							<td></td>
						</tr>
						<tr>
							<td>Matériaux non secs souillés de peinture, vernis, colle</td>
							<td>Matières plastiques composites, expansées, stratifiées, contrecollées</td> 
							<td></td>
						</tr>
						<tr>
							<td>Abrasifs</td>
							<td>Certaines peintures et vernis sans solvants</td> 
							<td></td>
						</tr>
						<tr>
							<td>Détergents</td>
							<td>Moquette</td> 
							<td></td>
						</tr>
						<tr>
							<td>Absorbants, filtres, essuyages, protections souillées</td>
							<td></td> 
							<td></td>
						</tr>
					</tbody>
					<thead  class="thead-dark">
						<tr>
							<th>Elimination en centre de traitements spécialisés et / ou stockage en CET I</th>
							<th>Recyclage ou valorisation après tri (de préférence sur chantier, stockage en CET II)</th> 
							<th>Recyclage Stockage en CET III</th>
						</tr>
					</thead>
				</table></p>
				<p>(1) : la valorisation des emballages est obligatoire, stockage interdit</p>
				<p>(2) : stockage en alvéole spécifique classe III ou CET II</p>
			</footer>
		</div>
	</body>
</html>