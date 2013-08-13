<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once __DIR__ . '/../vendor/autoload.php';

// Import declarations
use \Symfony\Component\HttpFoundation\Request as Request;
use \Symfony\Component\HttpFoundation\Response as Response;

// Start Silex
$app = new \Silex\Application();
$app['debug'] = true;

/**
 * Basic HTML render
 * @param string $content
 * @return string
 */
function html_render($content, $title)
{
    $html = '<!doctype html>
    <html lang="en">
    <head>
      <meta charset="utf-8">
      <title>' . $title . '</title>
      <meta name="description" content="' . $title . '">
      <meta name="author" content="Andrew Kirkpatrick <info@andrew-kirkpatrick.com">
    </head>
    <body>
      <h1>' . $title . '</h1>
      ' . $content . '
    </body>
    </html>';
    
    return $html;
}

/*
 * Define routes
 */

// Homepage
$app->get('', function(Request $request) use ($app) {
    
    $title = 'PHP Design Patterns';
    $content = '<h2>Patterns</h2>
        <ul>
        <li><a href=memento>Memento pattern</a></li>
        </ul>';
    return html_render($content, $title);
    
});

$app->get('memento', function(Request $request) use ($app) {
    
    $title = 'Memento';
    $content = '';
    return html_render($content, $title);
    
});

// Run Silex
$app->run();