<?php

/**
 * Filters paths that contain "http:" or "https:".
 *
 * @package Tx_Asdis
 * @subpackage System_Uri_Filter
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Uri_Filter_ContainsProtocol implements Tx_Asdis_System_Uri_Filter_FilterInterface {

	/**
	 * @param array $paths Array of paths.
	 * @return array Valid paths.
	 */
	public function filter(array $paths) {
		$filteredPaths = array();
		foreach($paths as $path) {
			if($this->containsProtocol($path) || $this->containsProtocolMarker($path)) {
				continue;
			}
			$filteredPaths[] = $path;
		}
		return $filteredPaths;
	}

	/**
	 * @param string $path
	 * @return boolean
	 */
	private function containsProtocol($path) {
		return (1 === preg_match('/^(http|https)\:/', $path));
	}

	/**
	 * @param string $path
	 * @return boolean
	 */
	private function containsProtocolMarker($path) {
		return (1 === preg_match('/^(###HTTP###|###HTTP_S###)/', $path));
	}
}