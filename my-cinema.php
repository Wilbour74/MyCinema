<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        
        html{
            background-image: url("Sallecinema.jpg");
         
            
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
    width: 400px;
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

<form method="GET">
<input type="text" class="text" name="text" placeholder="Choissisez un film"></input><br>

<input type="text" class="text" name="text1" placeholder="Choissisez un distributeur"></input>

<br>
<select name="selectedvalue">
    <option value="0">Selectionnez un genre</option>
    <option value="Action">Action</option>
    <option value="Adventure">Adventure</option>
    <option value="Animation">Animation</option>
    <option value="Biography">Biography</option>
    <option value="Comedy">Comedy</option>
    <option value="Crime">Crime</option>
    <option value="Drama">Drama</option>
    <option value="Family">Family</option>
    <option value="Fantasy">Fantasy</option>
    <option value="Horror">Horror</option>
    <option value="Mystery">Mystery</option>
    <option value="Romance">Romance</option>
    <option value="Sci-fi">Sci-fi</option>
    <option value="Thriller">Thriller</option>
    <input type="submit" name="envoyer"></input><br>
    
</select>
<a href="./my2-cinema.php">Voir les utilisateurs </a>
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

$query = $db->prepare("SELECT title FROM movie");
$query-> execute();
$demain = $query->fetchALL();
$valeur = $_GET['selectedvalue'];



if($valeur !== '0' AND empty($_GET['text']) AND empty($_GET['text1'])){

    $query = $db->prepare('SELECT movie.id, movie.title, id_movie, id_genre, genre.name, genre.id FROM movie INNER JOIN movie_genre ON movie.id=id_movie INNER JOIN genre ON genre.id=id_genre WHERE genre.name="'.$valeur.'"');
$query->execute();
}

elseif(isset($_GET['text1']) AND empty($_GET['text']) AND $valeur == '0'){
    $recherche = htmlspecialchars($_GET['text']);
    $recherche2 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT title,id_distributor, distributor.id, distributor.name from movie JOIN distributor ON movie.id_distributor=distributor.id where distributor.name LIKE "%'.$recherche2.'%" ');
    $query->execute();

}
elseif((isset($_GET['text'])) AND empty($_GET['text1']) AND $valeur == '0'){
    $recherche = htmlspecialchars($_GET['text']);
    $query = $db->prepare('SELECT title FROM movie WHERE title LIKE "'.$recherche.'%" ');
    $query->execute();
  
    }
elseif((isset($_GET['text'])) AND (isset($_GET['text1'])) AND $valeur == '0'){
    $recherche = htmlspecialchars($_GET['text']);
    $recherche2 = htmlspecialchars($_GET['text1']);
    $query = $db->prepare('SELECT movie.title, movie.id_distributor, distributor.id, distributor.name 
                            from movie 
                            JOIN distributor 
                            ON movie.id_distributor=distributor.id 
                            where distributor.name 
                            LIKE "'.$recherche2.'%" 
                            AND movie.title like  "'.$recherche.'%" ');
    $query->execute();  
}

 elseif(isset($_GET['text']) && empty($_GET['text1']) && $valeur !== '0'){
     $recherche = htmlspecialchars($_GET['text']);
    $query = $db->prepare('SELECT movie.id, movie.title, id_movie, id_genre, genre.name, genre.id FROM movie INNER JOIN movie_genre ON movie.id=id_movie INNER JOIN genre ON id_genre=genre.id WHERE genre.name="'.$valeur.'" and movie.title like "'.$recherche.'%" ');
     $query->execute();

 }

?>

<div class ="boite">
    <?php
    if($query->rowCount() > 0){
       while($demain = $query->fetchAll()){
        foreach ($demain as $donnee) {
    
        ?>
        
        
            
        <p><?php echo $donnee['title']; ?></p>
        
       
    
    <?php
    }
    ?>
            <?php
       } 
    }
    else{
        ?>
        <p>Aucun film trouvé</p>
        <?php
    }
?>
</div>

</body>
</html>













