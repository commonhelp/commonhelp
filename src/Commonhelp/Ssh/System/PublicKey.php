<?php
namespace Commonhelp\Ssh;
use Commonhelp\Resource\SubSystem;

class PublicKey extends SubSystem{
	
	public function createResource(){
		$resource = ssh2_publickey_init($this->getSessionResource());
		if (!is_resource($resource)) {
			throw new \RuntimeException('The initialization of the publickey subsystem failed.');
		}
		$this->resource = $resource;
	}
	
	/**
	 * Adds an authorized publickey
	 *
	 * @param  string  $algoname   The algorithm (e.g: ssh-dss, ssh-rsa)
	 * @param  string  $blob       The blob as binary data
	 * @param  Boolean $overwrite  Whether to overwrite the key if it already
	 *                             exist
	 * @param  array   $attributes An associative array of attributes to assign
	 *                             to the publickey. To mark an attribute as
	 *                             mandatory, precede its name with an asterisk.
	 *                             If the server is unable to support an
	 *                             attribute marked mandatory, it will abort
	 *                             the add process.
	 *
	 * @return Boolean TRUE on success, or FALSE on failure
	 */
	public function add($algoname, $blob, $overwrite = false, array $attributes = array()){
		return ssh2_publickey_add($this->getResource(), $algoname, $blob, $overwrite, $attributes);
	}
	
	/**
	 * Lists the currently authorized publickeys
	 *
	 * @return array A numerically indexed array of keys, each of which is an
	 *               associative array containing: name, blob, and attrs
	 *               elements.
	 */
	public function getList(){
		return ssh2_publickey_list($this->getResource());
	}
	
	/**
	 * Removes an authorized publickey
	 *
	 * @param  string $algoname The algorithm (e.g: ssh-dss, ssh-rsa)
	 * @param  string $blob     The blob as binary data
	 *
	 * @return Boolean TRUE on success, or FALSE on failure
	 */
	public function remove($algoname, $blob){
		return ssh2_publickey_remove($this->getResource(), $algoname, $blob);
	}
	
}

?>