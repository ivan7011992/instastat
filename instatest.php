<?php


use InstagramAPI\Instagram;
use InstagramAPI\Response\Model\Item;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/db.php';

function mediaUrl(Item $media): string
{

    switch ($media->getMediaType()) {
        case Item::PHOTO;
        case Item::VIDEO;
            $imageUrl = $media->getImageVersions2()->getCandidates()[0]->getUrl();
            break;
        case Item::CAROUSEL:
            $imageUrl = $media->getCarouselMedia()[0]->getImageVersions2()->getCandidates()[0]->getUrl();
            break;
    }
    return $imageUrl;
}

function insertMedia($accountId, Item $media): void
{
    global $DB;

    $DB->insertData('instagram_media', [
        'account_id' => $accountId,
        'image_url' => mediaUrl($media),
        'likes_count' => $media->getLikeCount() ?? 0,
        'comments_count' => $media->getComments() ?? 0,
        'description' => $media->getCaption()->getText(),
        'scrapped_at' => date("Y-m-d H:i:s"),
    ]);

}

function updateMedia(Item $media): void
{
    global $DB;
    $mediaID =$media->getPk();
    $DB->updateData('instagram_media',[
                    'likes_count' => $media->getLikeCount() ?? 0,
                    'comments_count' =>$media->getComments() ?? 0,
                    'description' => $media->getCaption()->getText(),
                     'image_url' => mediaUrl($media),
                     'scrapped_at'=> date("Y-m-d H:i:s")




    ],$mediaID);


}

function processMedias(array $medias, $accountId)
{
    global $DB;
    /** @var Item[] $medias */
    foreach ($medias as $media) {
        $imageUrl = mediaUrl($media);

        $dbmedias = $DB->select("SELECT * FROM instagram_media WHERE media_id = ? ", [$media->getPk()]);
        if (count($dbmedias) === 0) {
            insertMedia($accountId, $media);
        } else {
            updateMedia($media);
        }

        echo sprintf("Processed media %s\n", $media->getPk());
    }

}

function createClient(): Instagram
{
    $ig = new Instagram(false, true, [
        'storage' => 'mysql',
        'dbhost' => 'localhost',
        'dbname' => 'instastat',
        'dbusername' => 'root',
        'dbpassword' => 'root',
    ]);
    $ig->login('ivanacadem9228', 'BtR12345');
    echo "login success\n";
    return $ig;
}

function getUser(Instagram $ig, string $userName)
{
    $peopleResponse = $ig->people->getInfoByName($userName);
    $user = $peopleResponse->getUser();
    return $user;
}

function scrapeAccount(Instagram $ig, \InstagramAPI\Response\Model\User $user, string $userName): array
{
    global $DB;

    $accounts = $DB->select('select * from instagram_account where login = ?', [$userName]);

    if (count($accounts) > 0) {
        $DB->update('UPDATE instagram_account 
SET avatar_url=?, follower_count=?, followers_count=?, scrapped_at=?  WHERE login=?', [
            $user->getProfilePicUrl(),
            $user->getFollowerCount(),
            $user->getFollowingCount(),
            date("Y-m-d H:i:s"),
            $userName


        ]);
    } else {
        $DB->insertData("instagram_account", [
                "user_id" => $user->getPk(),
                "login" => $user->getUsername(),
                "avatar_url" => $user->getProfilePicUrl(),
                "followers_count" => $user->getFollowerCount(),
                "follower_count" => $user->getFollowingCount(),
                "scraped_at" => date("Y-m-d H:i:s")
            ]
        );
    }
    $accounts = $DB->select('select * from instagram_account where login = ?', [$userName]);
    $account = $accounts[0];

    echo sprintf("Get info for account %s\n", $userName);
    return $account;
}

function scrapMedia(Instagram $ig, \InstagramAPI\Response\Model\User $user, array $account): void
{
    $maxId = null;
    while (true) {
        $response = $ig->timeline->getUserFeed($user->getPk(), $maxId);
        processMedias($response->getItems(), $account['id']);

        $maxId = $response->getNextMaxId();
        if ($response->getMoreAvailable() === false) {
            break;
        }
    }
}
function queueCommentTasks(Instagram $ig,array $media){
      global $DB;

      $DB->insertData('queue',[
          'data' =>$media['id'],
          'comments' => 'comment'


      ]);





};


$userName = 'nehakakkar';

$ig = createClient();
$user = getUser($ig, $userName);
$account = scrapeAccount($ig, $user, $userName);
scrapMedia($ig, $user, $account);

$mediaIdq= scrapMedia($ig, $user, $account);


queueCommentTasks($ig,$mediaIdq);// функия,которая добавляет в талицу q задачу о сборе постов


//обрать комментарии с каждого поста через очередь

