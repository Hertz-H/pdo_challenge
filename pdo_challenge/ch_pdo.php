<?php

class DatabaseClass{
    private $dsn;
    private $username;
    private $password;
    private $database;
    private $pdo;
    
    function __construct()
    {
        $this->database="e-commerce";
        $this->dsn="mysql:host=localhost;dbname=$this->database;charset=utf8mb4";
        $this->username="root";
        $this->password="";
        $this->pdo=new PDO($this->dsn,$this->username,$this->password);
        
    }
   public function query($table,$col=-1,$col_val=1){
       if($col_val==1 || $col==-1){
        $stmt=$this->pdo->prepare("select * from $table");
        $stmt->execute(); 
        return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
       else{
        $stmt=$this->pdo->prepare("select * from $table where $col=?");
        $stmt->execute([$col_val]); 
        return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
       

    }
  public function modify($table,$col,$col_val,$condit_col=-1,$condit_val=-1){
        // $count=$this->pdo->exec("update $table set $col='$col_val' where $condit_col='$condit_val'");
        if($condit_val==-1 || $condit_col==-1){
            $stmt=$this->pdo->prepare("update $table set $col=? ");
            $count=$stmt->execute([$col_val]);
            return $count;
        }
      else{
        $stmt=$this->pdo->prepare("update $table set $col=? where $condit_col=?");
        $count=$stmt->execute([$col_val,$condit_val]);
        return $count;
      }

    }
    public function delete($table,$condit_col=-1,$condit_val=-1){
        // $count=$this->pdo->exec("delete from $table set $col='$col_val' where $condit_col='$condit_val'");
        if($condit_val==-1||$condit_col==-1){
            $stmt=$this->pdo->prepare("delete from $table");
            $count=$stmt->execute();
           return $count;
        }
        else{
            $stmt=$this->pdo->prepare("delete from $table where $condit_col=?");
            $count=$stmt->execute([$condit_val]);
           return $count;
        }
        

    }
    public function add($table,$name){
        $stmt=$this->pdo->prepare("insert into $table values(null,?,1)");
        $count=$stmt->execute([$name]);
        return $count;

    }

}
$db_obj=new DatabaseClass();
// $result=$db_obj->query("category","name","phones");
// $count=$db_obj->add("category","radioes");
// echo $count."<br>";
$count=$db_obj->delete("category","name","radioes");
echo $count."<br>";
// $count=$db_obj->modify("category","active","0","name","laptops");
// echo $count."<br>";
$result=$db_obj->query("category");
foreach($result as $row)
{
    echo "id  ".$row->id." name  ".$row->name." active  ".$row->active."<br>";
}

?>