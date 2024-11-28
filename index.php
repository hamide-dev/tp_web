<?php
$info = null ;
$bool = null ;
$affiche = null ;
$name_filiere =isset($_POST['filiere'])?$_POST['filiere']:null ;
$descript_filiere = isset($_POST['des_filiere'])?$_POST['des_filiere']:null ;

try{
    $db = new PDO('mysql:host=localhost;dbname=upb_bd_td_techno_web;charset=utf8','root', '') ;
} 

catch (Exception $e){
    die($e->getMessage()) ;
}
?>

<?php 
if( !empty($name_filiere) and !empty($descript_filiere) ){
    $requete = "SELECT COUNT(*) FROM filieres WHERE nom_filiere=:filiere";
    $verifie = $db->prepare($requete);
    $verifie->execute(
        [
            "filiere" =>htmlentities($name_filiere) 
        ]
    );
    $element  = $verifie->fetchColumn();

    if($element>0){
        $bool = true ; 
        $info = "la filiere $name_filiere que vous souhaitez enregistrer dans la base de donnes existe dejà" ;
    }
    else{  
        $bool = false ;
        $en = $db->prepare('INSERT INTO filieres (nom_filiere ,description_filiere) values (:nom ,:des)') ;
        $en->execute(
            [
                "nom" => htmlentities( $name_filiere ),
                "des"=> htmlentities($descript_filiere)
            ]
        ) ;  
    }


} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajout d'une filiere dans la base de données </title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
if(isset($_POST['filiere'])) {
    if(empty($_POST['filiere'])) {
        echo '<p>Veuillez saisir une filière.</p>';
    } else {
        if($bool) {
            echo '<div class="red"><p>'.htmlentities($info).'</p></div>';
        } else {
            echo "<div class='vert'><p> La filière  . htmlentities($name_filiere) .  a bien été ajoutée dans la base de données</p></div>";
        }
    }
}
?>
    <pre>
        <h1>espace administrateur</h1>
    </pre>
    <form action="" method="post">
        <div>
            <input type="text" name="filiere" placeholder="entrez le nom de la filiere">
        </div>
        <div>
            <input type="text" name="des_filiere" placeholder="entrez le nom complet de la filieres">
        </div>
        <div>
            <input type="submit" value="submit" class="en">
        </div>
    </form>
</body>
</html>