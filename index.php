<?php

	require('templates/function.php');
 
	
	echo renderTemplate('layout.php', [
    "title" => $title,
    "content" => renderTemplate('kanban.php', ['nazva' => $title]),
    ]);


