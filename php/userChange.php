<?php
    session_start();
    session_destroy();
    session_start();

    header("Content-Type:application/json"); 
    //$host = 'localhost'; 
    //$user = 'root';
    //$pw = '011051';
    //$dbName = 'opentutorials';
    $host = 'localhost'; 
    $user = 'root';
    $pw = '**uplus1214';
    $dbName = 'torest';
    $con = new mysqli($host, $user, $pw, $dbName);

    mysqli_set_charset($con,"utf8");
    $POST = JSON_DECODE(file_get_contents("php://input"), true); //mysql로 접근 하도록 설정
    $memberId = $POST["id"];

            $_SESSION["ses_username"] = $memberId;
            
            $res1 = mysqli_query($con, "select * from user where id = '$memberId' ");
            $res3 = mysqli_query($con, "select * from manage left join item on manage.itemNum = item.itemNum where id = '$memberId' ");
            $res5 = mysqli_query($con, "select * from test where id = '$memberId' ");
            
            $result = array(); 

            $row = mysqli_fetch_array($res1); 
            $result['name'] = $row[2];
            $result['profile'] = $row[3];
            $result['grade'] = $row[7];
          
            $item = array();

            while($row = mysqli_fetch_array($res3)) { 
            array_push($item, array('itemNum'=>$row[1],'itemLocation'=>$row[5],'itemName'=>$row[4],'location'=>$row[2]));
            }
            $result['item'] = $item;
           
            $chartData = array();
           
            while($row = mysqli_fetch_array($res5)) { 
            array_push($chartData, array('날짜' => $row[1], '점수' => $row[2]));
            }

            $result['chartData'] = $chartData; 

            //echo $result['name'];

        echo json_encode($result,JSON_UNESCAPED_UNICODE);

 mysqli_close($con);
 
?>