<?php

function abort(string $message, Throwable $th, array $extra = [])
{
    header("content-type: application/json");
    http_response_code(500);
    $response = array_merge([
        'message' => $message,
        'error' => $th->getMessage(),
        'trace' => $th->getTrace(),
    ], $extra);
    echo json_encode($response);
    die();
}
