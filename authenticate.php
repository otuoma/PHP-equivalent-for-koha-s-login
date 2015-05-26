<?php
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $dbhost = "";
        $dbuser = "";
        $dbpassword = "";
        $dbname = "";
        
        $userid = $_POST['user'];
        $password = $_POST['pass'];
        
        $con = mysql_connect($dbhost, $dbuser, $dbpassword) or  die("Could not connect: " . mysql_error());

        mysql_select_db($dbname);
        
        $result =  mysql_query("SELECT password FROM borrowers WHERE userid = '{$userid}' LIMIT 1;");

        while ($row = mysql_fetch_array($result)) {

            //for koha 3.13 and earlier
            $old_hash = rtrim(base64_encode(pack('H*', md5($password))), '=');
            
            //for koha 3.14 and later
            $new_hash = crypt($password, $row['password']);

            if( ($row['password'] === $old_hash) || ($row['password'] === $new_hash) ){
                echo "+Authentic";
            }  else {
                echo "Failed...........";
            }

        }
        mysql_close($con);
    }else{ //form is not submitted
    echo "go to home page";
?>
