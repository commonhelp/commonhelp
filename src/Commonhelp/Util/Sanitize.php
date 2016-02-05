<?php
namespace Commonhelp\Util;


class Sanitize{
	
	/**
	 * Checks and cleans a URL.
	 *
	 * @param string $url The URL to be cleaned.
	 * @return string The cleaned $url.
	 */
	public static function url($url){
		if('' == $url){
			return $url;
		}
		
		$url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
		$strip = array('%0d', '%0a', '%0D', '%0A');
		$url = self::deepReplace($strip, $url);
		$url = str_replace(';//', '://', $url);
		/* If the URL doesn't appear to contain a scheme, we
		 * presume it needs http:// appended (unless a relative
		 * link starting with /, # or ? or a php file).
		*/
		if (strpos($url, ':') === false && ! in_array($url[0], array('/', '#', '?')) &&
				! preg_match('/^[a-z0-9-]+?\.php/i', $url)){
				$url = 'http://' . $url;
		}
				
		
		$url = str_replace('&amp;', '&#038;', $url);
		$url = str_replace("'", '&#039;', $url);
		return $url;
	}
	
	/**
	 * Perform a deep string replace operation to ensure the values in $search are no longer present
	 *
	 * Repeats the replacement operation until it no longer replaces anything so as to remove "nested" values
	 * e.g. $subject = '%0%0%0DDD', $search ='%0D', $result ='' rather than the '%0%0DD' that
	 * str_replace would return
	 *
	 * @access private
	 *
	 * @param string|array $search
	 * @param string $subject
	 * @return string The processed string
	 */
	private static function deepReplace($search, $subject){
		$found = true;
		$subject = (string) $subject;
		while ($found){
			$found = false;
			foreach ((array) $search as $val){
				while (strpos( $subject, $val) !== false){
					$found = true;
					$subject = str_replace($val, '', $subject);
				}
			}
		}
		
		return $subject;
	}
	
}