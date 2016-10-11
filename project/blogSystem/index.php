<?php
/**
 * User: sometimes
 * Date: 2016/10/10
 * Time: 21:56
 */

$dsn = "mysql:host=localhost;dbname=db_movie;port=3307";
$username = 'root';
$password = 'root';
$pdo = new PDO($dsn,$username,$password);
$sql = 'select username,password,email from user';

try{
    $stm = $pdo->prepare($sql);
    $stm->bindColumn(1,$username);
    $stm->bindColumn(2,$password);
    $stm->bindColumn(3,$email);
    $rec = $stm->execute();

    if($rec){
        while($row = $stm->fetch(PDO::FETCH_BOUND)){
            echo $username;
            echo '<br/>';
            echo $password;
            echo '<br/>';
            echo $email;
            echo '<br/>';
            echo '<hr/>';
        }
    }


}catch (PDOException $e){
   var_dump($e->getMessage());
}


