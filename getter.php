<?php

require_once 'lib/simple_html_dom.php';
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");

//$input = $argv[1];
$input = $_POST['dd'];

$request = array(
'http' => array(
    'method' => 'POST',
    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
    'content' => http_build_query(array(
        'page' => 'worddict',
        'wdrst' => '0',
        'wdqtm' => '0',
        'wdqcham' => '1',
        'wdqt' => $input

    )),
)
);

$context = stream_context_create($request);

$html = file_get_html('https://www.mdbg.net/chinese/dictionary', false, $context, false);

function writeDom2File($dom, $output_filename)
{
	global $written_dom;
	$written_dom++;
	$myfile = fopen($output_filename."_".$written_dom.".html", "a") or die("Unable to open file!");
	fwrite($myfile, $dom."\r\n");
	fclose($myfile);
}


foreach($html->find('.resultswrap tr.row') as $dman)
{
	echo $dman->find('td.head',0)->plaintext."";
	echo $dman->find('td.details',0)->plaintext."<br><br>";
}