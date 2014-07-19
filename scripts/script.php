<?php
	if(isset($_POST['file'])){
		try{
		    $bdd = new PDO('mysql:host=localhost;dbname=tools', 'root', 'acddadd');
			$base = file("http://localhost/SSS/Tools/web/app_dev.php/audit/add/audit?nom_client=killian");
			$array = file("http://localhost/SSS/Tools/web/app_dev.php/audit/add/audit?nom_client=killian&fct=fct");
			$restants = array_diff($array, $base);
			$lenght = 50 + count($restants) - 4;
			for($i = 50; $i < $lenght; $i++){
				$categorie = '';
		    	$req = $bdd->prepare("INSERT INTO Questions (categorie, type_audit, question) VALUES (:categorie, 8, :question)");
				$bool = $req->execute(array(
					'categorie' => $categorie,
					'question' => $restants[$i]));
				if(!$bool){
			throw new Exception('fdsq');
				}
			}
		}
		catch (Exception $e)
		{
		        die('Erreur : ' . $e->getMessage());
		}


	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	    <title>remplir la bdd</title>
    </head>
	<body>
	<?php
		if(isset($message)){
			var_dump($message);
		}
	?>
		<form action="#" method="post">
			<label for="file">String pour acceder au fichier : </label><input type="text" id="file" name="file" />
			<br /><input type="submit" />
		</form>
	</body>
</html>
<!-- Moteur de recherche
Le site propose-t-il un moteur de recherche?
Le moteur de recherche est-il positionné en haut à droite de la page principale?
Le moteur de recherche est-il visible sur l'ensemble des pages web?
Le moteur de recherche est-il facilement identifiable commme tel?
La zone de recherche est-elle suffisamment longue ( > 20 caractères)?
Si la recherche n'a rien donné, le message est-il sympathique?
Les résultats sont-ils classés par ordre de pertinence?
Les résultats présentent-ils un extrait des contenus de la page dans lequel sont surlignés les mots recherchés?
Les doublons ont-ils été éliminés?
Une recherche avancée est-elle proposée?

Formulaires
Le site propose-t-il un formulaire  de contact?
Ce formulaire est-il facilement accessible?
Les champs obligatoires sont-ils indiqués?
La vérification des champs de saisie se fait-elle avant l'envoie des données au serveur?
La touche entrée valide-t-elle le formulaire?
Les renseignements demandés sont-ils en adéquation avec la demande (pas trop de renseignements demandés)?
Les listes déroulantes sont-elles de taille raisonnable (> 6 choix)?
Après avoir validé le formulaire, un message informant de la bonne prise en compte de l'envoie est-il présent?

Téléchargements
Le site propose-t-il des documents en téléchargement?
L'intitulé des documents est-il explicite?
L'extension des documents est-elle précisée?
Le format de fichier est-il portable et ne nécessite-t-il pas l'installation de programmes spécifiques?
Le poids du document est-il indiqué avant de lancer le téléchargement?
Le poids des fichiers est-il raisonnable ( < 30 Mo)?

Plan d'acces
Le site propose-t-il un plan d'accès?
Les coordonnées complètes de l'entreprise sont-elles indiquées?
Le plan d'accès permet-il de zoomer en avant et en arrière?
Est-il possible de calculer un itinéraire?
Est-il possible d'imprimer le plan d'accès?

Impression
La fonctionnalité imprimer la page est-elle proposée?
La mise en page ne prend-elle en compte que le contenu principal?
L'impression est-elle optimisée pour des pages au format A4?
L'URL de la page est-elle présente sur l'impression?

E-business
Le descriptif des produits est-il bien détaillé?
Les photos des produits sont-elles suffisamment détaillées?
Les coordonnées du service client sont-elles facilement identifiables?
Les informations sur la politique de retour des marchandises sont-elle facilement accessibles?
Les conditions générales de ventes sont-elles accessible avant la finalisation de la commande?
Les informations sur la facturation sont-ellles facilement accessibles?
Les informations sur les modalités et les tarifs de livraison sont-elles facilement accessibles?
Les mentions CNIL sont-elles affichées en conformité?
La transaction est-elle sécurisée (HTTPS)?
Les informations sur la sécurité informatique et des données sont-elles facilement accessible?

Collaboratives
Le site web propose-t-il une newsletter?
L'inscription à la newsletter est-elle facilement accessible?
Est-il possible de commenter les articles?
Y a-t-il un encart mettant en avant les derniers articles?
Les articles en rapport avec l'article lu par l'internaute sont-ils affichés?
Le site propose-t-il un flux RSS?
Le site offre-t-il la possiblité d'envoyer la page par mail?
Le site propose-t-il la possiblité de partager la page sir les réseaux sociaux?
Le site propose-t-il des enquetes ou des sondages?
Ces enquètes ou sondages sont-ils discrets et composés d'une seule question? -->


