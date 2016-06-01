<?php
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $dbhost = "";
        $dbuser = "";
        $dbpassword = "";
        $dbname = "";
        
        $userid = $_POST['user'];
        $password = $_POST['pass'];
        
        $con = new PDO("mysql:dbname='{$dbname}';host='{$dbhost}';charset=utf8", '{$dbuser}', '{$dbpassword}');
        $con->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $stmt = $con->prepare("SELECT password FROM borrowers WHERE userid = ? LIMIT 1;");
        $stmt->bind_param('s', $userid);
        
        $stmt->execute();
        
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {

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
    echo "<a href='http://networkbooks.co.ke'>Go Home</a>";
?>
