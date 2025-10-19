<?php
require __DIR__ . '/helpers.php';
require __DIR__ . '/Illuminate/Foundation/Http/FormRequest.php';
require __DIR__ . '/../app/Http/Controllers/Controller.php';
// global route() helper stub
if (!function_exists('route')) {
	function route($name, $params = null) { return (string)$name; }
}

// Provide a typed $conn variable for static analysis environments (null at runtime in stubs)
/** @var \mysqli|null $conn */
$conn = null;
