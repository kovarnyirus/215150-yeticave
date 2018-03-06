<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');
require_once('vendor/autoload.php');

$lots = sql_get_lots_end($db_connect);
foreach ($lots as $lot){
   $winner = sql_get_last_bet($db_connect, [$lot['id']]);
   $update_winner = sql_update_winner($db_connect, [$winner[0]['user_id'], $lot['id']]);
   if ($update_winner){
        send email
   }
}

