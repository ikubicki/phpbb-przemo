<?php

use PhpBB\Forum\Url;
use PhpBB\Core\Context;

$request = Context::getService('request');
$template = Context::getService('templates');
$phrases = Context::getService('phrases');
$tree = Context::getService('tree');
$category_id = $request->get->get('c');

if ($category_id) {
    $tree = $category = (new PhpBB\Model\CategoriesCollection)->get($category_id);
    if (empty($category)) {
        error404('category');
    }
    $nesting = - $category->getNesting() - 1;
}
else {
    $nesting = 0;
}

$template->vars([
    'title' => !empty($category) ? $category->getName() : $phrases->Forum_index,
    'forums' => $tree ? $tree->flat(true, $nesting) : null,
    'category' => $category ?? null,
]);

$template->component('FORUMS', 'main/components/forums.html');

if (isset($category)) {
    $template->var('A_ITEMS', Context::getService('tree')->trace($category));
}

(new PhpBB\Modules\Shouts\Module)->start();

$template->display('main/viewcategory.html');