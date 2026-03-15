<?php

declare(strict_types=1);

require __DIR__.'/http_client.php';

$createResponse = request_json('POST', SERVICE_TASK_PATH, [
    'title' => 'Test the web service',
    'description' => 'You should test the web service considering all possible invocations.',
]);
print_response('POST /todo/api/tasks', $createResponse);

$taskId = $createResponse['body']['task']['id'] ?? null;
if ($taskId === null) {
    throw new RuntimeException('Could not read task id from POST response.');
}

$listResponse = request_json('GET', SERVICE_TASK_PATH);
print_response('GET /todo/api/tasks', $listResponse);

$updateResponse = request_json('PUT', SERVICE_TASK_PATH.'/'.$taskId, [
    'title' => 'Test web service X',
    'description' => 'You should test this web service.',
    'done' => true,
]);
print_response("PUT /todo/api/tasks/{$taskId}", $updateResponse);

$deleteResponse = request_json('DELETE', SERVICE_TASK_PATH.'/'.$taskId);
print_response("DELETE /todo/api/tasks/{$taskId}", $deleteResponse);
