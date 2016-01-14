<?php
namespace Commonhelp\Util\Security;

use Commonhelp\App\SystemConfig;

class Hasher{
	
	/** @var SystemConfig */
	private $config;
	
	/** @var array Options passed to password_hash and password_needs_rehash */
	private $options = array();
	
	/** @var string Salt used for legacy passwords */
	private $legacySalt = null;
	
	/** @var int Current version of the generated hash */
	private $currentVersion = 1;
	
	/**
	 * @param SecurityConfig $config
	 */
	function __construct(SystemConfig $config) {
		$this->config = $config;
		$hashingCost = $this->config->getHashingCost(null);
		if(!is_null($hashingCost)) {
			$this->options['cost'] = $hashingCost;
		}
	}
	
	/**
	 * Hashes a message using PHP's `password_hash` functionality.
	 * Please note that the size of the returned string is not guaranteed
	 * and can be up to 255 characters.
	 *
	 * @param string $message Message to generate hash from
	 * @return string Hash of the message with appended version parameter
	 */
	public function hash($message) {
		return $this->currentVersion . '|' . password_hash($message, PASSWORD_DEFAULT, $this->options);
	}
	
	/**
	 * Get the version and hash from a prefixedHash
	 * @param string $prefixedHash
	 * @return null|array Null if the hash is not prefixed, otherwise array('version' => 1, 'hash' => 'foo')
	 */
	protected function splitHash($prefixedHash) {
		$explodedString = explode('|', $prefixedHash, 2);
		if(sizeof($explodedString) === 2) {
			if((int)$explodedString[0] > 0) {
				return array('version' => (int)$explodedString[0], 'hash' => $explodedString[1]);
			}
		}
		return null;
	}
	
	/**
	 * Verify legacy hashes
	 * @param string $message Message to verify
	 * @param string $hash Assumed hash of the message
	 * @param null|string &$newHash Reference will contain the updated hash
	 * @return bool Whether $hash is a valid hash of $message
	 */
	protected function legacyHashVerify($message, $hash, &$newHash = null) {
		if(empty($this->legacySalt)) {
			$this->legacySalt = $this->config->getPasswordsalt('');
		}
		// Verify whether it matches a legacy PHPass or SHA1 string
		$hashLength = strlen($hash);
		if($hashLength === 60 && password_verify($message.$this->legacySalt, $hash) ||
				$hashLength === 40 && StringUtils::equals($hash, sha1($message))) {
					$newHash = $this->hash($message);
					return true;
				}
				return false;
	}
	/**
	 * Verify V1 hashes
	 * @param string $message Message to verify
	 * @param string $hash Assumed hash of the message
	 * @param null|string &$newHash Reference will contain the updated hash if necessary. Update the existing hash with this one.
	 * @return bool Whether $hash is a valid hash of $message
	 */
	protected function verifyHashV1($message, $hash, &$newHash = null) {
		if(password_verify($message, $hash)) {
			if(password_needs_rehash($hash, PASSWORD_DEFAULT, $this->options)) {
				$newHash = $this->hash($message);
			}
			return true;
		}
		return false;
	}
	
	/**
	 * @param string $message Message to verify
	 * @param string $hash Assumed hash of the message
	 * @param null|string &$newHash Reference will contain the updated hash if necessary. Update the existing hash with this one.
	 * @return bool Whether $hash is a valid hash of $message
	 */
	public function verify($message, $hash, &$newHash = null) {
		$splittedHash = $this->splitHash($hash);
		if(isset($splittedHash['version'])) {
			switch ($splittedHash['version']) {
				case 1:
					return $this->verifyHashV1($message, $splittedHash['hash'], $newHash);
			}
		} else {
			return $this->legacyHashVerify($message, $hash, $newHash);
		}
		return false;
	}
}
