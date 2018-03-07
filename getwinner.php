<?php
require_once('functions.php');
require_once('db_connect.php');
require_once('data.php');
require_once('sql_functions.php');
require_once('vendor/autoload.php');

function sendMailToWinner($db_connect){
    $lots = sql_get_lots_end($db_connect);
    foreach ($lots as $lot){
        $winner = sql_get_last_bet($db_connect, [$lot['id']]);
        if (isset($winner[0])){
            $update_winner = sql_update_winner($db_connect, [$winner[0]['user_id'], $lot['id']]);
            $winner_template = render_template('email', [
                'user_name' => $winner[0]['name'],
                'lot_name' => $lot['lot_name'],
                'lot_id' => $lot['id']
            ]);

            $transport = (new Swift_SmtpTransport('smtp.yandex.com', 465, 'SSL'))
                ->setUsername('testphpmails@yandex.com')
                ->setPassword('test123');
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message('Ваша ставка победила'))
                ->setFrom(['testphpmails@yandex.com' => 'Andrew'])
                ->setTo([strval($winner[0]['user_email']) => strval($winner[0]['name'])])
                ->setBody($winner_template, 'text/html');
            $send = $mailer->send($message);
        }
    }
}

sendMailToWinner($db_connect);
