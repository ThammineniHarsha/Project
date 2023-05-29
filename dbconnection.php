<?php

        $hostname='localhost';
        $password='';
        $user='root';
        $dbname='ovs';

        $connection=mysqli_connect($hostname,$user,$password,$dbname);
        if(!$connection){
            echo "<script>alert('please connect to the database')</script>";
        }

?>