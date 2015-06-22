<?php

/**
 * Provides all configuration settings.
 *
 * @package Tx_Asdis
 * @subpackage System_Configuration
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_System_Configuration_Provider {

	/**
	 * @var Tx_Asdis_System_Configuration_TypoScriptConfiguration
	 */
	private $typoScriptConfiguration;

	/**
	 * @param Tx_Asdis_System_Configuration_TypoScriptConfiguration $typoScriptConfiguration
	 */
	public function injectTypoScriptConfiguration(Tx_Asdis_System_Configuration_TypoScriptConfiguration $typoScriptConfiguration) {
		$this->typoScriptConfiguration = $typoScriptConfiguration;
	}

	/**
	 * Tells if the assets on the current page should be replaced.
	 *
	 * @return boolean
	 */
	public function isReplacementEnabled() {
		return (boolean) ((integer) $this->typoScriptConfiguration->getSetting('enabled'));
	}

	/**
	 * This disables any processing in hook handlers of the asdis extension.
	 * You can use this, if you have to implement your own hook processing in another extension.
	 *
	 * @return boolean
	 */
	public function isDefaultHookHandlingDisabled() {
		return (boolean)((integer)$this->typoScriptConfiguration->getSetting('disableDefaultHookHandling'));
	}

	/**
	 * @return string
	 */
	public function getDistributionAlgorithmKey() {
		return (string) $this->typoScriptConfiguration->getSetting('distributionAlgorithm');
	}

	/**
	 * Returns the scraper keys for the current page.
	 *
	 * @return array
	 */
	public function getScraperKeys() {
		$keyList = $this->typoScriptConfiguration->getSetting('scrapers', 'string');
		$keys    = explode(",", $keyList);
		if (FALSE === is_array($keys) || sizeof($keys) < 1) {
			return array();
		}
		$scraperKeys = array();
		foreach ($keys as $key) {
			$scraperKeys[] = trim($key);
		}
		return $scraperKeys;
	}

	/**
	 * Returns the filter keys for the current page.
	 *
	 * @return array
	 */
	public function getFilterKeys() {
		$keyList = $this->typoScriptConfiguration->getSetting('filters', 'string');
		$keys    = explode(",", $keyList);
		if (FALSE === is_array($keys) || sizeof($keys) < 1) {
			return array();
		}
		$filterKeys = array();
		foreach ($keys as $key) {
			$filterKeys[] = trim($key);
		}
		return $filterKeys;
	}

	/**
	 * Returns an array like this:
	 * array(
	 *     array(
	 *         'identifier' => 'media1',
	 *         'domain'     => 'm1.mydomain.com',
	 *         'protocol'   => 'dynamic'
	 *     ),
	 *     array(
	 *         'identifier' => 'media2',
	 *         'domain'     => 'm2.mydomain.com',
	 *         'protocol'   => 'http'
	 *     )
	 * )
	 *
	 * @return array
	 * @throws Tx_Asdis_System_Configuration_Exception_InvalidStructure
	 */
	public function getServerDefinitions() {
		$definitions = array();
		$serverDefinitions = $this->typoScriptConfiguration->getSetting('servers', 'array', TRUE);
		foreach($serverDefinitions as $identifier => $serverDefinition) {
			if(FALSE === is_array($serverDefinition) || FALSE === isset($serverDefinition['domain'])) {
				throw new Tx_Asdis_System_Configuration_Exception_InvalidStructure(
					'Configured server definition for "'.((string) $serverDefinition) . '" is invalid.',
					1372159113552
				);
			}
			if(FALSE === isset($serverDefinition['protocol'])) {
				$serverDefinition['protocol'] = 'marker';
			}
			$definitions[] = array(
				'identifier' => $identifier,
				'domain'     => $serverDefinition['domain'],
				'protocol'   => $serverDefinition['protocol']
			);
		}
		return $definitions;
	}

	/**
	 * @return string
	 */
	public function getServerProtocolMarker() {
		return $this->typoScriptConfiguration->getSetting('serverProtocolMarker', 'string');
	}
}