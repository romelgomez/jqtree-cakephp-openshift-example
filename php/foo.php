<?php
//print $_ENV['PATH'];
class foo {
	public $myvar = getenv('PATH');
	
	public function __contruct() {
		print $myvar;
	}
}


?>
