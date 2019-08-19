<?php

$dsn = "pgsql:"
    . "host=ec2-54-247-171-30.eu-west-1.compute.amazonaws.com;"
    . "dbname=d40146vimk501b;"
    . "user=udjybajmcsxiwa;"
    . "port=5432;"
    . "sslmode=require;"
    . "password=a3986dc80f463c20ba5418c769ae2f1906aaaf9642d37fd534c949fb0af3fab0";

$db = new PDO($dsn);
?>