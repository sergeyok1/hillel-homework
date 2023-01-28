<?php

	require('templates/function.php');
	$title='Завдання та проекти | Дошка';
	$fname='nizhnik';
	$vb='sergey';
	$src = 'data:image/jpeg;base64,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';
	$src1 = 'data:image/jpeg;base64,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';
	$page = 'not page' ;
	
	
	echo renderTemplate('a.php', ['lname' => $vb, 'fname' => $fname, 'src' => $src]);
	echo renderTemplate('a.php', ['lname' => 'saha', 'fname' => 'zaya', 'src' => $src1]); 
	echo renderTemplate('a.php', ['lname' => 'xyulo', 'fname' => 'putin', 'page' => $page ]); 
	
	/*echo renderTemplate('layout.php', [
    "title" => $title,
    "content" => renderTemplate('kanban.php', ['nazva' => $title]),
]);*/
	


  //require_once('templates/layout.php');


