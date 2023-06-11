<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
       <style type="text/css">
        
        html{
            background-image: url("bdg.png");
         
            
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
            background-color: orange;
            padding: 10px;
        }
        table {
        border: 5px solid;
        background-color: blue;
        width:100%;
        }
        th, td{
            border: 5px solid;
            width:5%;

        }

        th{
            background-color: black;
        }

        td{
            background-color: black;
        }
        


.table1{
    max-height: 600px;
    overflow-y: scroll;
    overflow-x: hidden;
    width: 600px;
    background-color: black;
    text-align: center;
    
    margin: auto;
}
</style>

       
</head>
<header>
    <h1>Ciné Will</h1>
</header>
<body>
    <form>
    <input type="text" class="text" name="text" placeholder="Entrez un nom"></input><br>
    <input type="text" class="text" name="text1" placeholder="Entrez un prénom"></input>
    <input type="submit" name="envoyer"></input><br>
    <a href="./my3-cinema.php">Clique ici pour voir les abonnés</a>
</form>


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
$query = $db->prepare("SELECT firstname, lastname FROM user");
$query-> execute();
$demain = $query->fetchALL();

if(isset($_GET['text']) and empty($_GET['text1'])){
    $recherche = htmlspecialchars($_GET['text']);
    $query = $db->prepare('SELECT firstname, lastname from user WHERE lastname LIKE "'.$recherche.'%"');
    $query-> execute();
}

elseif(isset($_GET['text1']) and empty($_GET['text'])){
    $recherche = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT firstname, lastname from user WHERE firstname LIKE "'.$recherche.'%"');
    $query-> execute();

}

elseif(isset($_GET['text']) and isset($_GET['text'])){
    $recherche = htmlspecialchars($_GET['text']);
    $recherche1 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT firstname, lastname from user Where firstname like "'.$recherche1.'%" AND lastname like "'.$recherche.'%"' );
    $query->execute();
}
?>
<div class = "table1">
    <?php
    if($query->rowCount() > 0){
       while($demain = $query->fetchAll()){
        foreach ($demain as $donnee) {
            $prenom = $donnee['firstname'];
            $nom = $donnee['lastname'];
    ?>
        <table>
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
        </tr>
        <tr>
            <td><?php echo "$prenom";?></td>
            <td><?php echo "$nom"; ?></td>
        </tr>
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