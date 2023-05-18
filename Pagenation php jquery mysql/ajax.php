<?php

require_once 'partials/user.php';

extract($_POST);



if($_POST['type'] == "allData"){
    echo $user->getAllData(0,4);
}

//get count of function 
if($_POST['type'] == 'getallusers'){
    $page=(!empty($_POST['page']))?$_POST['page']:1;

    $limit = 4;
    
    $start=($page-1)*$limit;

    $users=$user->getRows($start,$limit);

    if(!empty($users)){
            $userlist=$users;
    }else{$userlist=[];}
    $total=$user->getCount();
    $userArr=['count'=>$total,'users'=>$userlist];
    echo json_encode($userlist);
    exit();
    

}

if($_POST['type'] == 'getrowcount'){
    echo $user->getSum();
}