<?php
/**
 * User: keven
 * Date: 2016/10/11
 * Time: 13:38
 */
try{
    $dsn = "mysql:host=localhost;dbname=test;";
    $username = 'root';
    $password = 'root';
    $pdo = new PDO($dsn,$username,$password);

   $pdo->beginTransaction();
    $sql1 = 'update back set money=money-2000 where name="immoc"';
    if($pdo->exec($sql1)==0){
        throw new PDOException('immoc转款失败');
    }
    $sql2 = 'update back set money=money+2000 where name="concise"';
    if($pdo->exec($sql2)==0){
        throw new PDOException('concise收款失败');
    }
    $pdo->commit();
echo '转账成功';
}catch (PDOException $e){
    $pdo->rollBack();
    print_r($pdo->errorInfo());
    echo $e->getMessage();
}