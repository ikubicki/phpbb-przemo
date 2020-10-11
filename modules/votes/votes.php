<?php


$data = [
    'posts' => []
];

for ($i = 1; $i < 1000; $i++) {
    $data['posts'][$i] = ['id' => $i, 'count' => mt_rand(-100, 100), 'voted' => mt_rand(-1, 1)];
}

header('Content-type: application/json');
echo json_encode($data);