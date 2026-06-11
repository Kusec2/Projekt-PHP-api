<?php
define('__APP__', TRUE);

$MySQL = mysqli_connect("localhost", "root", "", "projekt")
    or die("Error connecting to MySQL server.");

// Postavi Content-Type na XML
header("Content-Type: application/rss+xml; charset=utf-8");

$query  = "SELECT id, title, description, picture, date FROM news";
$query .= " WHERE archive='N' ORDER BY date DESC";
$result = mysqli_query($MySQL, $query);

$dom = new DOMDocument("1.0", "UTF-8");
$dom->formatOutput = true;

// RSS korijeni element
$rss = $dom->createElement("rss");
$rss->setAttribute("version", "2.0");
$dom->appendChild($rss);

// Channel element
$channel = $dom->createElement("channel");
$rss->appendChild($channel);

// Informacije o kanalu
$channel->appendChild($dom->createElement("title",       "3D Printanje - Vijesti"));
$channel->appendChild($dom->createElement("link",        "http://localhost/PHP-projekt"));
$channel->appendChild($dom->createElement("description", "Najnovije vijesti o 3D printanju"));
$channel->appendChild($dom->createElement("language",    "hr"));

// Vijesti
while ($row = mysqli_fetch_assoc($result)) {
    $item = $dom->createElement("item");

    $item->appendChild($dom->createElement("title",       htmlspecialchars($row['title'])));
    $item->appendChild($dom->createElement("description", htmlspecialchars(strip_tags($row['description']))));
    $item->appendChild($dom->createElement("pubDate",     htmlspecialchars($row['date'])));
    $item->appendChild($dom->createElement("link", htmlspecialchars("http://localhost/PHP-projekt/index.php?menu=3&action=" . $row['id'])
));

    $channel->appendChild($item);
}

echo $dom->saveXML();
mysqli_close($MySQL);
?>