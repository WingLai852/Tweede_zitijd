<?php
require_once __DIR__ . '/../config.php';

class taskList {
    private $pdo;

    private $id;
    private $user_id;
    private $taak;

    public function __construct($user_id, $taak){
        $database = new Database();
        $this->pdo = $database->pdo;
        
        $this->setUserId($user_id); 
        $this->setTaak($taak);
 }

 //setter
 public function setId($id){
     $this->id = $id;
 }

 public function setUserId($user_id){
    if(empty($user_id)){
        throw new Exception("user_id mag niet leeg zijn");
    }
    $this->user_id = $user_id;
 }

 public function setTaak($taak){
    if(empty($taak)){
        throw new Exception("taak mag niet leeg zijn");
    }
    $this->taak = $taak;
 }

 //getters

public function getId(){
    return $this->id;
}

public function getUserId(){
    return $this->user_id;
}

public function getTaak(){
    return $this->taak;
}

//database
public function save (){
    $stmt = $this->pdo->prepare("INSERT INTO list (user_id, taak) VALUES (?, ?)");
    return $stmt->execute([$this->user_id, $this->taak]);
}

public static function delete($id) {
    $database = new Database();
    $pdo = $database->pdo;
    $stmt = $pdo->prepare('DELETE FROM lists WHERE id = ?');
    return $stmt->execute([$id]);
}

public static function getAllByUserId($user_id) {
    $database = new Database();
    $pdo = $database->pdo;
    $stmt = $pdo->prepare('SELECT * FROM lists WHERE user_id = ?');
    $stmt->execute([$user_id]);
    return $stmt->fetchAll();
}
}
?>