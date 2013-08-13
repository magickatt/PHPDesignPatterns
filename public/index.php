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
    
    /*
     * Object instantiation
     */
    
    $object = new Model\Memento\Memento();
    
    $content = '<h2>New object</h2><pre>' . print_r($object, true) . '</pre>';
    
    /*
     * Property assignment
    */
    
    $object->name = 'Sam';
    $object->gender = 'Male';
    $object->age = 25;
    
    $content .= <<<'EOT'
<h2>Object property assignment</h2>
<pre>$object->name = 'Sam';
$object->gender = 'Male';
$object->age = 25;</pre>
EOT;
    
    $content .= '<h2>Populated object</h2><pre>' . print_r($object, true) . '</pre>';
    
    /*
     * Rollback
     */
    
    $object->rollback(1);
    
    $content .= <<<'EOT'
<h2>Rollback</h2>
<pre>$object->rollback(1);</pre>
EOT;
    
    $content .= '<h2>Rolled back object</h2><pre>' . print_r($object, true) . '</pre>';
    
    $object->name = 'Steve';
    $object->age = 28;
    
    $content .= <<<'EOT'
<h2>Object property amendments</h2>
<pre>$object->name = 'Steve';
$object->age = 28;</pre>
EOT;
    
    $content .= '<h2>Updated object</h2><pre>' . print_r($object, true) . '</pre>';
    
    /*
     * Commit
     */
    
    $object->commit();
    
    $content .= <<<'EOT'
<h2>Commit</h2>
<pre>$object->commit();</pre>
EOT;
    
    $content .= '<h2>Committed object</h2><pre>' . print_r($object, true) . '</pre>';
    
    return html_render($content, $title);
});

// Run Silex
$app->run();