<?php
// include ('searchController.php');







        $id="";
        if(isset($_GET['searchId'])) $id=$_GET['searchId'];
        

        $serverName = '54.69.239.219';
        $userName = 'lyihan';
        $password= '900225';
        $database = 'EmailCrawlerDB';
        $con = mysqli_connect($serverName,$userName,$password,$database);
        if (!$con)
        {
            echo("fail");
            die('Could not connect: ' . mysql_error());
        }
        

        

        $sql1='select customer_linkedin_url from Result where search_id="'.$id.' limit 50";';
                // $sql1='select * from Result where search_id="20170621234247153";';
        $result=mysqli_query($con, $sql1 );
        $response=array();
        while($row = mysqli_fetch_array($result,MYSQLI_NUM)){
            $response[]=$row[0];

        }

        $response2=array();
        foreach ($response as $url) {
            $sql2='select customer_name from Customer where customer_linkedin_url="'.$url.'";';

            $result2=mysqli_query($con, $sql2 );
            $response2[]=mysqli_fetch_row($result2);
        }

        $response3=array();
        foreach ($response as $url) {
            $sql3='select customer_title from Customer where customer_linkedin_url="'.$url.'";';

            $result3=mysqli_query($con, $sql3 );
            $response3[]=mysqli_fetch_row($result3);
        }

        $response4=array();
        foreach ($response as $url) {
            $sql4='select email_address from Email where customer_linkedin_url="'.$url.'";';
            $email=array();     
            $result4=mysqli_query($con, $sql4 );
            while($row = mysqli_fetch_row($result4)){
                $email[]=$row[0];
            }
            
            array_push($response4,$email);

            
            
        }




        

        $result=array($response,$response2,$response3,$response4);

        echo json_encode($result);

        mysqli_close($con);


    