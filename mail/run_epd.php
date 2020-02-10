<?php

shell_exec('php add_to_queue.php');

for ($i = 0; $i < 5; $i++) {
    $cmd = 'php send_mail.php';
    $outputFile = sprintf('log_%d.txt' , $i);

    exec(sprintf("%s > %s 2>&1 &", $cmd, $outputFile));
}