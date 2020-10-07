<?php
//$_POST['error'] = 'hello world';
$_POST['session'] = [
    'id' => 2
];
$_POST['messages'] = [
    ['id' => 1, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 1', 'time' => '1 dzień temu'],
    ['id' => 2, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 2', 'time' => '30m temu'],
    ['id' => 3, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 3', 'time' => '20m temu'],
    ['id' => 4, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 4', 'time' => '18m temu'],
    ['id' => 5, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 5', 'time' => '16m temu'],
    ['id' => 6, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 6', 'time' => '12m temu'],
    ['id' => 7, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 7', 'time' => '11m temu'],
    ['id' => 8, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 8', 'time' => '10m temu'],
    ['id' => 9, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 9', 'time' => '10m temu'],
    ['id' => 10, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 10', 'time' => '6m temu'],
    ['id' => 11, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'orem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ac vulputate velit. Aliquam in rhoncus urna. Fusce mattis leo ac sollicitudin malesuada. Etiam at justo nunc. Vestibulum sit amet enim ac nisi volutpat scelerisque at nec sapien. Maecenas at maximus risus. Donec massa mauris, vulputate sed nulla at, bibendum tempus tellus. In id feugiat est. Vivamus vitae nisl libero.', 'time' => '5m temu'],
    ['id' => 12, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 12', 'time' => '2m temu'],
    ['id' => 13, 'author' => ['id' => 2, 'name' => 'bolec', 'url' => 'viewprofile.php?id=2'], 'text' => 'hello world 13', 'time' => 'minutę temu'],
];
echo json_encode($_POST);