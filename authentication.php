<?php
    if(isset($_POST['user']) && isset($_POST['pass'])){
        
        $dbHost = "db host here";   //replace with actual value
        $dbUser = "dbUsername";     //replace with actual value
        $dbPass = "dbPassword";     //replace with actual value
        $kohaDB = "kohaDB";         //replace with actual value

        $con = mysql_connect($dbHost, $dbUser, $dbPass) or  die("Could not connect: " . mysql_error());

        mysql_select_db($kohaDB);
        
        $userid = $_POST['user'];
        $password = $_POST['pass'];
        
        $result =  mysql_query("SELECT password FROM borrowers WHERE userid = '{$userid}' LIMIT 1;");
        
        while ($row = mysql_fetch_array($result)) {
            
            $old_hash = rtrim(base64_encode(pack('H*', md5($password))), '=');
            
            $new_hash = crypt($password, $row['password']);
            
            if( ($row['password'] === $old_hash) || ($row['password'] === $new_hash) ){
                echo "+Authentic";
            }  else {
                echo "Failed...........";
            }
            
        }
        mysql_close($con);
    }else{ //script accessed without form data redirect to a page of your choice
        
        echo "<a href='http://networkbooks.co.ke'>Go Home</a>";
    }


