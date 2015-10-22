<?php
require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();
$app['debug'] = true;

$app['couchdb'] = \Doctrine\CouchDB\CouchDBClient::create(
    array(
        'dbname' => 'doctrine_example2',
        'host' => 'couchdb',
    )
);

$app->get('/', function() use($app) {
    $client = $app['couchdb'];

    // Create a database.
    $client->createDatabase($client->getDatabase());

// Create a new document.
    list($id, $rev) = $client->postDocument(array('foo' => 'bar'));

// Update a existing document. This will increment the revision.
    list($id, $rev) = $client->putDocument(array('foo' => 'baz'), $id, $rev);

// Fetch single document by id.
    $doc = $client->findDocument($id);

// Fetch multiple documents at once.
    $docs = $client->findDocuments(array($id));

// Return all documents from database (_all_docs?include_docs=true).
    $allDocs = $client->allDocs();

// Delete a single document.
    $client->deleteDocument($id, $rev);

// Delete a database.
    $client->deleteDatabase($client->getDatabase());

    return $id;
});

$app->run();
