<?php

use Illuminate\Support\Facades\Http;
use PhpParser\Node\Stmt\TryCatch;

function createPremiumAccess($data){
    $url = env('SERVICE_COURSE_URL').'api/my-courses/premium';
    try {
        $response = Http::post($url, $data);
        $data = $response->json();
        $data['http_code'] = $response->getStatusCode();
        return $data;
    } catch (\Throwable $th) {
        return [
            'status' => 'error',
            'http_code' => 500,
            'message' => 'Service unavailable.'
        ];
    }
}