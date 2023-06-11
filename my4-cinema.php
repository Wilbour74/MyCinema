<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="GET">
    <p>Recherchez une date de projection</p>
    <input type="datetime-local" name="text8">
    <input type="submit" name="text9">

<form>
<p>Ajoutez une séance</p> 
        <input type="text" name="text" placeholder="ajoutez un film"><br>
        <input type="datetime-local" name ="text1"><br>
        <input type="submit" name = "text3" placeholder="cliquez ici pour validé">
        
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
$query = $db->prepare('SELECT id_movie, date_begin, movie.id, movie.title from movie_schedule inner join movie on id_movie=movie.id');
$query->execute();

if(isset($_GET['text8'])){
    
    $date = $_GET['text8'];
    $query = $db->prepare('SELECT id_movie, date_begin, movie.id, movie.title from movie_schedule inner join movie on id_movie=movie.id WHERE TIMESTAMP(date_begin)="'.$date.'"');
    $query->execute();
}  

elseif(isset($_GET['text']) and isset($_GET['text1'])){
    $recherche = htmlspecialchars($_GET['text']);
    $date9 = $_GET['text1'];
    $query = $db->query('INSERT INTO movie_schedule (date_begin ,movie.title) VALUES ('.$date9.', '.$recherche.')');
    
}
?>
<?php
    if($query->rowCount() > 0){
       while($demain = $query->fetchAll()){
        foreach ($demain as $donnee) {

            $date1 = $donnee['date_begin'];
            $film = $donnee['title'];
        
        
       
?>    <p><?php echo "$film $date1"; ?></p>
            
    <?php
       }?>
       <?php
    }
}?>           
            



</body>
</html>