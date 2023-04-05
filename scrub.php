<?php
// Create a new cURL resource
$curl = curl_init();

// Set the URL and other cURL options
curl_setopt($curl, CURLOPT_URL, "https://example.com"); // Replace with the website URL you want to scrape
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Send the request and get the response
$response = curl_exec($curl);

// Close cURL resource
curl_close($curl);

// Load the HTML into a DOMDocument
$dom = new DOMDocument();
$dom->loadHTML($response);

// Find all the links on the page and store them in an array
$links = array();
foreach($dom->getElementsByTagName('a') as $link) {
    $href = $link->getAttribute('href');
    $text = $link->nodeValue;
    $links[] = array('href' => $href, 'text' => $text);
}

// Open a connection to the database
$servername = "localhost"; // Replace with your database server name
$username = "username"; // Replace with your database username
$password = "password"; // Replace with your database password
$dbname = "database_name"; // Replace with your database name

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Insert the links into the database
foreach($links as $link) {
    $href = mysqli_real_escape_string($conn, $link['href']);
    $text = mysqli_real_escape_string($conn, $link['text']);
    $sql = "INSERT INTO links (href, text) VALUES ('$href', '$text')";
    mysqli_query($conn, $sql);
}

// Close the database connection
mysqli_close($conn);
?>
