<?php

require_once __DIR__ . '/testframework.php';
require_once __DIR__ . '/../site/config.php';
require_once __DIR__ . '/../site/modules/database.php';
require_once __DIR__ . '/../site/modules/page.php';

$tests = new TestFramework();

// Test 1: Check database connection
$tests->add('Database connection', function() {
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db instanceof Database, "Connection OK", "Connection FAIL");
});

// Test 2: Test count method
$tests->add('table count', function() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $count = $db->Count("page");
    return assertExpression($count >= 3, "Count OK", "Count FAIL");
});

// Test 3: Test create method
$tests->add('data create', function() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "Test Page", "content" => "Test Content"]);
    return assertExpression($id > 0, "Create OK", "Create FAIL");
});

// Test 4: Test read method
$tests->add('data read', function() {
    global $config;
    $db = new Database($config["db"]["path"]);
    $data = $db->Read("page", 1);
    return assertExpression($data['id'] == 1, "Read OK", "Read FAIL");
});

$tests->run();

echo $tests->getResult();
