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
<p>Tapez le prénom et le nom d'un abonnée pour connaitre son historique</p>
<input type="text" class="text" name="text" placeholder="Entrez un nom"></input><br>
    <input type="text" class="text" name="text1" placeholder="Entrez un prénom"></input>
    <input type="submit" name="envoyer"></input>
</form>
<a href="./my3-cinema.php">Clique ici pour retourner en arrière</a>
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
$b = $_GET['cache1'];
$query= $db->prepare('SELECT firstname, lastname, user.id, id_user, movie.id, movie.title, id_session, id_membership from user INNER JOIN membership ON id_user=user.id INNER JOIN movie INNER JOIN membership_log on id_membership=user.id AND id_session=movie.id WHERE id_user = "'.$b.'" ');
$query->execute();
$valeur = $_GET['envoyer'];


if(isset($_GET['text']) and empty($_GET['text1'])){
    $recherche = htmlspecialchars($_GET['text']);
    $query = $db->prepare('SELECT firstname, lastname, user.id, id_user, movie.id, movie.title, id_session, id_membership from user INNER JOIN membership ON id_user=user.id INNER JOIN movie INNER JOIN membership_log on id_membership=user.id AND id_session=movie.id WHERE lastname = "'.$recherche.'%"  ');
    $query-> execute();
}

elseif(isset($_GET['text1']) and empty($_GET['text'])){
    $recherche1 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT firstname, lastname, user.id, id_user, movie.id, movie.title, id_session, id_membership from user INNER JOIN membership ON id_user=user.id INNER JOIN movie INNER JOIN membership_log on id_membership=user.id AND id_session=movie.id WHERE firstname = "'.$recherche1.'%" ');
    $query-> execute();

}



elseif(isset($_GET['text']) and isset($_GET['text'])){
    $recherche = htmlspecialchars($_GET['text']);
    $recherche1 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT user.id, firstname, lastname, membership.id, membership.id_user, membership.id_subscription, subscription.id, subscription.name FROM user INNER JOIN membership ON user.id=membership.id INNER JOIN subscription ON subscription.id=membership.id_subscription WHERE firstname like "'.$recherche1.'%" AND lastname like "'.$recherche.'%"' );
    $query->execute();
}
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
            $movie = $donnee['title'];
            
            
            
            
    ?>
        <p><?php echo "$movie\n"; ?></p>
        <form method="GET">
        <input type="hidden" name="cache1" value="<?php echo $donnee['id']?>">
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