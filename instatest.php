<?php

use InstagramAPI\Instagram;
use InstagramAPI\InstagramID;

require __DIR__.'/vendor/autoload.php';

$ig = new Instagram(false, true, [
    'storage'    => 'mysql',
    'dbhost'     => 'localhost',
    'dbname'     => 'instastat',
    'dbusername' => 'root',
    'dbpassword' => 'root',
]);
$ig->login('ivanacadem92','BTR12345');
echo 'login success';

//$mediaId = InstagramID::fromCode('B6h_JyvHKpR');
//$mediaResponse = $ig->media->getInfo($mediaId);
//$media = $mediaResponse->getItems()[0];
//$media->getMediaType()

$peopleResponse = $ig->people->getInfoByName('nehakakkar');

//$rows = [];
//$rows[count($rows) - 1]

// Какие данные собрать:
// информация об аккаунте - id, login, кол-во подписок и подписчиков
// информация о постах в аккаунте - о каждом посте нужно получить -
// url изображения, кол-во лайков, комментариев, описание поста