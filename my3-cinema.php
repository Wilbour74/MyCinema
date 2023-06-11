<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        
        html{
            background-image: url("vip.avif");
         
            
            background-size: cover;
            
        }
        body{
            
            color : white;
        }

        form{
            margin-left : auto;
            margin-right : auto;
            width : 300px;
            margin-bottom: 50px;
            
        }
        input{
            background-color: blue;
            padding: 10px;
        }
        table, th, td {
        border: 5px solid;
        background-color: blue;
        
}

.boite{
    max-height: 300px;
    overflow-y: scroll;
    overflow-x: hidden;
    width: 300px;
    background-color: black;
    text-align: center;
    padding: 16px;
    margin: auto;
}


        
    </style>
</head>
<header>
    <h1>Ciné Will</h1>
</header>
<body>
<form>
<p>Tapez le prénom et le nom d'une personne pour connaitre son abonnement</p>
<input type="text" class="text" name="text" placeholder="Entrez un nom"></input><br>
    <input type="text" class="text" name="text1" placeholder="Entrez un prénom"></input>
    <input type="submit" name="envoyer"></input>
</form>
<form>

<!-- <input type="text" class="text" name="text3" placeholder="Entrez un nom">    
<input type ="text" class="text" name="text4" placeholder="Entrez un prénom">
<select class="selectedvalue1" name="select">
            <option value="0" disabled selected>Choissisez un rang</option>
            <option value="1">VIP</option>
            <option value="2">GOLD</option>
            <option value="3">Classic</option>
            <option value="4">Pass Day</option>
            <option value ="5">Supprimer l'abonnement</option>
</select> -->
 
<a href="./my2-cinema.php">Clique ici pour retourner en arrière</a><br>
<a href="./my3bis_cinema.php">Clique ici pour avoir les historiques</a>
<?php 
$dsn = 'mysql:dbname=cinema;host=127.0.0.1';
$user = 'wilfried_bour';
$password = "will";
$db = new PDO($dsn, $user, $password);




try{
    $db;
}
catch(PDOException $e){
    error : $e->getMessage();
}
if($valeur >= 0 && $valeur <=5){
$query = $db->prepare('SELECT user.id, firstname, lastname, membership.id, membership.id_user, membership.id_subscription, subscription.id, subscription.name FROM user INNER JOIN membership ON user.id=membership.id INNER JOIN subscription ON subscription.id=membership.id_subscription;');
$query-> execute();
// $demain = $query->fetchALL(PDO::FETCH_COLUMN, 7);
// while ($demain->rowCount() > 0) {
//         foreach ($demain as $id) {
//             $id_c = $id['name'];
//     }
// }

// $power = $db->prepare('SET FOREIGN_KEY_CHECK = 0');
// $power = $db->execute();
// $test = ('SELECT id from user');
// $test1 = $db->prepare($test);
// $test1->execute();

// $test3 = $test1->fetchAll();
$valeur = $_GET['envoyer'];



 

if(isset($_GET['text']) and empty($_GET['text1'])){
    $recherche = htmlspecialchars($_GET['text']);
    $query = $db->prepare('SELECT user.id, firstname, lastname, membership.id, membership.id_user, membership.id_subscription, subscription.id, subscription.name FROM user INNER JOIN membership ON user.id=membership.id INNER JOIN subscription ON subscription.id=membership.id_subscription WHERE lastname LIKE "'.$recherche.'%"');
    $query-> execute();
}

elseif(isset($_GET['text1']) and empty($_GET['text'])){
    $recherche = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT user.id, firstname, lastname, membership.id, membership.id_user, membership.id_subscription, subscription.id, subscription.name FROM user INNER JOIN membership ON user.id=membership.id INNER JOIN subscription ON subscription.id=membership.id_subscription WHERE firstname LIKE "'.$recherche.'%"');
    $query-> execute();

}



elseif(isset($_GET['text']) and isset($_GET['text'])){
    $recherche = htmlspecialchars($_GET['text']);
    $recherche1 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT user.id, firstname, lastname, membership.id, membership.id_user, membership.id_subscription, subscription.id, subscription.name FROM user INNER JOIN membership ON user.id=membership.id INNER JOIN subscription ON subscription.id=membership.id_subscription WHERE firstname like "'.$recherche1.'%" AND lastname like "'.$recherche.'%"' );
    $query->execute();
}
elseif($valeur != '0' AND $valeur != '5'){
    $power = $db->query('SET FOREIGN_KEY_CHECKS = 0');

    $sub = $_GET["select"];
    $a = $_GET['cache'];
    $b = $_GET['cache1'];
    $query = $db->query('UPDATE membership set  membership.id_subscription = '.$sub.' WHERE id_user = '.$b.'');
    echo "Changement effectué";
    // $requete = $db->prepare($query);
    // $requete->execute();
    // $requete2 = $requete->fetchAll();
    // printr_r($requete2);
   
    //  echo 'UPDATE membership set  membership.id_subscription = '.$a.' WHERE id_user = '.$b.'; ';
 
}

elseif($valeur = '5'){
    $power = $db->prepare('SET FOREIGN_KEY_CHECKS = 0');
$power = $db->execute();
    $b = $_GET['cache1'];
    $query = $db->prepare('DELETE FROM membership WHERE id_user = "'.$b.'"');
     $query->execute();
}
}
// else{
//     $valeur = $_GET['envoyer']; 
//     $b = $_GET['cache1'];
//     $query= $db->prepare('SELECT firstname, lastname, user.id, id_user, movie.id, movie.title, id_session, id_membership from user INNER JOIN membership ON id_user=user.id INNER JOIN movie INNER JOIN membership_log on id_membership=user.id AND id_session=movie.id WHERE id_user = "'.$b.'" ');
//     $query->execute();
//     $pierre = $query->fetchALL();
//     foreach($pierre as $queue){
//         $queue['movie.id'];
//     }
//     echo $queue;
//     }


//  elseif($valeur != '0' AND $valeur != '5'){
//      $b = $_GET['cache1'];
//     $query = $db->prepare('DELETE FROM membership WHERE id_user = "'.$b.'" ');
//      $query->execute();
//      echo "Nikomouk";
//  }



?>

<div class="boite">
    <?php
    if($query->rowCount() > 0){
       while($demain = $query->fetchAll()){
        foreach ($demain as $donnee) {
            $prenom = $donnee['firstname'];
            $nom = $donnee['lastname'];
            $rang = $donnee['name'];
            $id = $donnee['id_subscription'];
            $id_user = $donnee['id_user'];
            
            
            
            
    ?>
        <p><?php echo "prénom = $prenom"; ?></p>
        <p><?php echo "nom = $nom"; ?></p>
        <p><?php echo "rang = $rang"; ?></p>
        
        <form method="GET" name="azer">
        <select class="selectedvalue" name="select">
            <option value="0" disabled selected>Choissisez un rang</option>
            <option value="1">VIP</option>
            <option value="2">GOLD</option>
            <option value="3">Classic</option>
            <option value="4">Pass Day</option>
            <option value ="5">Supprimer l'abonnement</option>
            <option value ="6">Afficher l'historique</option>
        </select>
        <form method="GET">
        <input type="hidden" name="cache" value="<?php echo $donnee['id_subscription']?>">
        
        <input type="hidden" name="cache1" value="<?php echo $donnee['id_user']?>">        
        <input type="submit" name="envoyer">
        
        
        </form>
       
   
    
    <?php
    }
    ?>
            <?php
       } 
    }
    else{
        ?>
        <p>Pas d'utilisateur trouvé</p>
        <?php
    }
?>
</div>
</body>
</html>