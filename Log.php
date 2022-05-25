<?php
/**
 * Require the library
 */
require 'PHPTail.php';
/**
 * Initilize a new instance of PHPTail
 * @var PHPTail
 */

foreach(new DirectoryIterator('/var/backups/mysql/binlogs_from_master_backup/logs_done_imported/') as $item) {
    if ($item->isFile() && (empty($file) || $item->getMTime() > $file->getMTime())) {
        $file = clone $item;
    }
}
if ($file->getExtension() === 'log') { $s = $file->getPathname(); }
#echo $file->getPathname();

foreach(new DirectoryIterator('/var/backups/mysql/binlogs_from_master_backup/logs_has_erorr/') as $item) {
    if ($item->isFile() && (empty($file1) || $item->getMTime() > $file1->getMTime())) {
        $file1 = clone $item;
    }
}
if ($file1->getExtension() === 'log') { $m = $file1->getPathname(); }

$tail = new PHPTail(array(
  #  "Access_Log" => "/var/backups/mysql/binlogs_reports/imported_logs/showsqlprocesslist.out",
  #  "Error_Log" => $s,
	"test_Log" => "/var/backups/mysql/binlogs_reports/imported_logs/showsqlprocesslist.out",
	#"Success_Log" => $s,
	"Error_Log" => $m,
));

/**
 * We're getting an AJAX call
 */

	// $query = '\b(?:CREATE|DROP)\b';

	$query = '\b(?:INSERT|CREATE|DROP|UPDATE|DELETE|ALTER|TRUNCATE|BACKUP)\b';

if(isset($_GET['ajax']))  {
	
	#echo '--------------';
	

	#echo $tail->getNewLines($_GET['file'], $_GET['lastsize'], $_GET['grep'], $_GET['invert']);
    echo $tail->getNewLines($_GET['file'], $_GET['lastsize'], $query, $_GET['invert']);
	

    die();
}

/**
 * Regular GET/POST call, print out the GUI
 */
$tail->generateGUI();
