<?php

define('__APP__', true);

require_once '../dbconn.php';

header('Content-Type: application/xml; charset=utf-8');

$query = "SELECT * FROM news WHERE archive='N' ORDER BY date DESC";
$result = mysqli_query($MySQL, $query);

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><news></news>');

while($row = mysqli_fetch_assoc($result))
{
    $item = $xml->addChild('item');

    $item->addChild('id', $row['id']);
    $item->addChild('title', htmlspecialchars($row['title']));
    $item->addChild('description', htmlspecialchars($row['description']));
    $item->addChild('picture', htmlspecialchars($row['picture']));
    $item->addChild('date', $row['date']);
}

echo $xml->asXML();