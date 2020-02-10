<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../db.php';

function processTask(array $data)
{
    echo "Processing user={$data['user_id']}\n";
    sleep(2);
}

function processAnotherTask(array $data) {

}

function processQueue(string $queueName, callable $callback)
{
    global $DB;

    while (true) {
        $DB->query('START TRANSACTION');

        $tasks = $DB->select('SELECT * from queue where name=? AND status=1 LIMIT 1 FOR UPDATE', [
            $queueName
        ]);
        if (count($tasks) === 0) {
            break;
        }

        $task = $tasks[0];
        $DB->update('UPDATE queue SET status=? WHERE id=?', [
            2,
            $task['id']
        ]);

        $DB->query('COMMIT');

        $data = json_decode($task['data'], true);
        $callback($data);
        $DB->update('DELETE FROM queue WHERE id=?', [$task['id']]);
    }
}


processQueue('epd_mail', 'processAnotherTask');

