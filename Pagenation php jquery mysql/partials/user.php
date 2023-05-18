<?php

require_once 'database.php';

extract($_POST);

Class User extends Database{

 
    function getSum(){
        try{

            $stmt = $this->conn->prepare("SELECT COUNT(id) as c FROM userdetails");
            $stmt->execute();
            
        if($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            return $row['c'];
        }else{
            return null;
        }

        }catch(PDOException $e){
            echo $e->getMessage();
            $this->conn->rollBack();
        }
    }

    function getAllData($start,$end){

        $table = '<table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
        ';
        try{
            
            $sql = $this->conn->prepare("SELECT * FROM userdetails LIMIT $start,$end");

            if($sql->execute()){
                while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    $table .= '<tr>
                    <th>'.$row['name'].'</th>
                    <th>'.$row['address'].'</th>
                    <th>'.$row['mobile'].'</th>
                    <th>'.$row['email'].'</th>
                  </tr>';
                }

                $table .= '</tbody></table>';
            }

            return $table;
            

        }catch(PDOException $e){
            echo $e->getMessage();
            $this->conn->rollBack();
        }
    }

    public function getRows($start=0, $limit=4){
        

        $table = '<table class="table">
        <thead>
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Address</th>
            <th scope="col">Mobile</th>
            <th scope="col">Email</th>
          </tr>
        </thead>
        <tbody>
        ';
        try{
            
            $sql = $this->conn->prepare("SELECT * FROM userdetails ORDER BY id DESC LIMIT {$start}, {$limit}");

            if($sql->execute()){
                while($row=$sql->fetch(PDO::FETCH_ASSOC)){
                    $table .= '<tr>
                    <th>'.$row['name'].'</th>
                    <th>'.$row['address'].'</th>
                    <th>'.$row['mobile'].'</th>
                    <th>'.$row['email'].'</th>
                  </tr>';
                }

                $table .= '</tbody></table>';
            }

            return $table;
            

        }catch(PDOException $e){
            echo $e->getMessage();
            $this->conn->rollBack();
        }

       

    }

    public function getCount(){
        $sql=$this->conn->prepare("SELECT count(*) as pcount FROM userdetails");
        $sql->execute();
        $result=$sql->fetch(PDO::FETCH_ASSOC);
        return $result['pcount'];
    }
   
}

$user = new User();