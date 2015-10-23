<?php
namespace Commonhelp\Ssh;

use Commonhelp\Resource\SubSystem;

class Exec extends SubSystem{
	
	protected function createResource(){
		$this->resource = $this->getSessionResource();
	}
	
	public function run($cmd, $pty = null, array $env = array(), $width = 80, $height = 25, $width_height_type = SSH2_TERM_UNIT_CHARS){
		$stdout = ssh2_exec($this->getResource(), $cmd, $pty, $env, $width, $height, $width_height_type);
		$stderr = ssh2_fetch_stream($stdout, SSH2_STREAM_STDERR);
		stream_set_blocking($stderr, true);
		stream_set_blocking($stdout, true);
		$error = stream_get_contents($stderr);
		if ($error !== '') {
			throw new \RuntimeException($error);
		}
		return stream_get_contents($stdout);
	}
	
}

?>