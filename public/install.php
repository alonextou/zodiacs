<?php

// This entire class should be rewritten to be a method, rather than a page in /public.

require '../config.php';
require '../libraries/database.php';

$db = new Database();

// Although PDO is supposed to be database agnostic, I still found this minor difference:
if (DB_TYPE == 'sqlite') {
    $autoIncrement = 'AUTOINCREMENT';
} else if (DB_TYPE == 'mysql') {
    $autoIncrement = 'AUTO_INCREMENT';
}

$messages = array();

// This checks if a table called zodiacs already exists, which means someone already ran the installation.
// There must be some broken logic for this script to be called twice, but just in case..
try {
    $sql = "SELECT 1 FROM `zodiacs`";
    $result = $db->query($sql);
    $messages[] = 'The installation has already been done!';
    // Ahh! We're being hacked! Someone wants too much installation! Abort to printResult()!
    // Now calling a function with an argument (our array with one message). This function is at the bottom.
    printResult($messages);
} catch (PDOException $e) {
    // Remember, the [] just pushes one more value onto an array.
    // We're kind of using try / catch backwards on this one... no big deal!
    $messages[] = 'Welcome to the installation process.';
    $messages[] = 'Niner delta G14 classified access granted!';
}

// Creating our Zodiacs table...
try {
    $sql = "CREATE TABLE IF NOT EXISTS zodiacs (
		id INTEGER PRIMARY KEY " . $autoIncrement . ",
		name TEXT,
		season TEXT,
		element TEXT
	)";
    // Last time we used $db->query(), this time we're using $db->exec(). Small differences you can Google.
    // Later you will also see $db->prepare(). http://net.tutsplus.com/tutorials/php/php-database-access-are-you-doing-it-correctly/
    $result = $db->exec($sql);
    $messages[] = 'Zodiacs table was created';
} catch (PDOException $e) {
    // If it fails, We'll skip to printResult() and the last message will be this error message.
    // Otherwise, the messages[] keep adding up and skipping these catch blocks.
    $messages[] = $e->getMessage();
    printResult($messages);
}

// Lets add some initial Zodiacs!
$zodiacs = array();
$zodiacs[] = array('name' => 'Tiger', 'season' => 'Spring', 'element' => 'Wood');
$zodiacs[] = array('name' => 'Rabbit', 'season' => 'Spring', 'element' => 'Wood');
$zodiacs[] = array('name' => 'Dragon', 'season' => 'Spring', 'element' => 'Earth');
$zodiacs[] = array('name' => 'Snake', 'season' => 'Summer', 'element' => 'Fire');
$zodiacs[] = array('name' => 'Horse', 'season' => 'Summer', 'element' => 'Fire');
$zodiacs[] = array('name' => 'Goat', 'season' => 'Summer', 'element' => 'Earth');
$zodiacs[] = array('name' => 'Monkey', 'season' => 'Autumn', 'element' => 'Metal');
$zodiacs[] = array('name' => 'Rooster', 'season' => 'Autumn', 'element' => 'Metal');
$zodiacs[] = array('name' => 'Dog', 'season' => 'Autumn', 'element' => 'Earth');
$zodiacs[] = array('name' => 'Pig', 'season' => 'Winter', 'element' => 'Water');
$zodiacs[] = array('name' => 'Rat', 'season' => 'Winter', 'element' => 'Water');
$zodiacs[] = array('name' => 'Ox', 'season' => 'Winter', 'element' => 'Earth');
// Lets loop this array and insert each one to our database.
foreach ( $zodiacs as $zodiac ) {
    try {
        // Now you see PDO's famous prepared statements... $db->prepare() and $db->execute()...
        // Technically there's not much point here because we're not getting input from the user,
        // but you can see we're casting $zodiac values from our foreach loop to relating :fields.
        // This is how I like to do it, but there are a few ways: http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        $sql = $db->prepare("INSERT INTO `zodiacs` (`name`, `season`, `element`) VALUES (:name, :season, :element)");
        $sql->execute(array(
            ':name' => $zodiac['name'],
            ':season' => $zodiac['season'],
            ':element' => $zodiac['element']
        ));
        $messages[] = $zodiac['name'] . ' was added to the database!';
    } catch (PDOException $e) {
        $messages[] = $e->getMessage();
        printResult($messages);
    }
}

// Now lets create a config table.
try {
    $sql = "CREATE TABLE IF NOT EXISTS config (
		id INTEGER PRIMARY KEY " . $autoIncrement . ",
		name TEXT,
		setting TEXT
	)";
    $result = $db->exec($sql);
    $messages[] = 'Config table was created.';
} catch (PDOException $e) {
    $messages[] = $e->getMessage();
    printResult($messages);
}

// And finally, we'll set an install config so our application knows its been installed.
try {
    $sql = $db->prepare("INSERT INTO `config` (`name`, `setting`) VALUES (:name, :setting)");
    $sql->execute(array(
        ':name' => 'installed',
        ':setting' => 'true'
    ));
    $messages[] = 'Congratulations! You deserve a drink!';
} catch (PDOException $e) {
    $messages[] = $e->getMessage();
    printResult($messages);
}

printResult($messages);

// The following function only gets called during an error message, or at the end of everything else...
// Functions don't run unless their called.
function printResult($messages) {
    echo '<div id="install-result" class="four columns push-four panel">';
    foreach ( $messages as $message ) {
        echo '<p>' . $message . '</p>';
    }
    echo '<a href="index.php" class="button full-width">Return</a>';
    die; // This kills the script so the rest doesn't process if this function was called early.
}