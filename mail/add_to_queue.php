<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db.php';

$DB->insert('DELETE FROM queue WHERE name=?',[
    'epd_mail'
]);

$userIds = range(1, 5000);

foreach ($userIds as $userId) {
    $data = ['user_id' => $userId];

    $DB->insertData('queue', [
        'name' => 'epd_mail',
        'status' => 1,
        'data' => json_encode($data)
    ]);
}

