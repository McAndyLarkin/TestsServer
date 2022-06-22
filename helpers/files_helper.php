<?php

function get_files_from_directory(string $path, ?string $ext) {
	return glob(sprintf($path."/*.%s", $ext ?? '*'));
}

function get_files_content($files) {
	$files_content = "[";
	foreach ($files as $file) {
		$files_content .= get_file_content($file).',';
	}
	$files_content .= ']';
	return $files_content;
}

function get_file_content($file) {
	return file_get_contents($file);
}