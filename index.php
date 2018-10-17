<?php
# -*- coding: utf-8 -*-
# __author__ = "Hadi Aminzadeh"
require_once 'vendor/autoload.php';

$conf = parse_ini_file("nodes.conf", true);
$nodes_item = $conf["nodes"];
$access = $conf["access"];

$node = array();
foreach ($nodes_item as $key => $host) {

    $dict_wsrep = array();
    $dict_wsrep['hostname'] = $host;
    $dict_wsrep['wsrep_local_state'] = 0;
    $dict_wsrep['wsrep_local_state_comment'] = 'Error';

    $cnx = new mysqli($host, $access['user'], $access['pass'], 'mysql', $access['port']);
    if ($cnx->connect_errno) {
        $dict_wsrep['wsrep_local_state_comment'] = mb_strcut($cnx->connect_error, 0, 10);
        $node[] = $dict_wsrep;
        continue;
    }

    $result = $cnx->query("SELECT @@hostname as hostname;");
    if ($result->num_rows > 0){
        $row = @$result->fetch_assoc();
        $dict_wsrep['hostname'] = $row['hostname'];
    }
    
    $result = $cnx->query("SHOW STATUS LIKE 'wsrep%';");
    if ($result->num_rows > 0){
        while ($row = @$result->fetch_row()) {
            $dict_wsrep[$row[0]] = $row[1];
        }
    }
    $cnx->close();

    $node[] = $dict_wsrep;
}

$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
    'cache' => false,//'templates/cache',
));

echo $twig->render('index.html', array('nodes'=>$node));

