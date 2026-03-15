<?php

declare(strict_types=1);

require __DIR__.'/http_client.php';

$tasksResponse = request_json('GET', SERVICE_TASK_PATH);
print_response('GET /todo/api/tasks', $tasksResponse);

$firstTaskId = $tasksResponse['body']['tasks'][0]['id'] ?? 1;
$singleTaskResponse = request_json('GET', SERVICE_TASK_PATH.'/'.$firstTaskId);
print_response("GET /todo/api/tasks/{$firstTaskId}", $singleTaskResponse);
