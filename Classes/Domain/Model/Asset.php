<?php

/**
 * Represents an asset.
 *
 * @package Tx_Asdis
 * @subpackage Domain_Model
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Domain_Model_Asset {

	/**
	 * @var string
	 */
	private $originalPath;

	/**
	 * @var string
	 */
	private $normalizedPath;

	/**
	 * @var Tx_Asdis_Domain_Model_Server
	 */
	private $server;

	/**
	 * The mask character in the content. eg. " or '
	 * @var string
	 */
	private $mask;

	/**
	 * @return string
	 */
	public function getHash() {
		return md5($this->originalPath);
	}

	/**
	 * @param string $originalPath
	 */
	public function setOriginalPath($originalPath) {
		$this->originalPath = $originalPath;
	}

	/**
	 * @return string
	 */
	public function getOriginalPath() {
		return $this->originalPath;
	}

	/**
	 * @param string $normalizedPath
	 */
	public function setNormalizedPath($normalizedPath) {
		$this->normalizedPath = $normalizedPath;
	}

	/**
	 * @return string
	 */
	public function getNormalizedPath() {
		return $this->normalizedPath;
	}

	/**
	 * @return string
	 */
	public function getPregQuotedOriginalPath() {
		return '~/?' . preg_quote($this->originalPath) . '~is';
	}

	/**
	 * @return string
	 */
	public function getMaskedPregQuotedOriginalPath()
	{
		$mask = preg_quote($this->getMask());
		return '~/?' . $mask . preg_quote($this->originalPath) . $mask . '~is';
	}

	/**
	 * @param Tx_Asdis_Domain_Model_Server $server
	 */
	public function setServer(Tx_Asdis_Domain_Model_Server $server) {
		$this->server = $server;
	}

	/**
	 * @return Tx_Asdis_Domain_Model_Server
	 */
	public function getServer() {
		return $this->server;
	}

	/**
	 * @return string
	 */
	public function getUri() {
		$domain = '';
		if(isset($this->server)) {
			$domain = $this->server->getUri();
		}
		return $domain . $this->normalizedPath;
	}

	/**
	 * @return string
	 */
	public function getMask() {
		return $this->mask;
	}

	/**
	 * @param string $mask
	 */
	public function setMask($mask) {
		$this->mask = $mask;
	}
}