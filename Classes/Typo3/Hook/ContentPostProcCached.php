<?php

/**
 * Handles hook ContentPostProcCached.
 *
 * @package Tx_Asdis
 * @subpackage Typo3_Hook
 * @author Timo Fuchs <timo.fuchs@aoemedia.de>
 */
class Tx_Asdis_Typo3_Hook_ContentPostProcCached extends Tx_Asdis_Typo3_Hook_AbstractHook {

	/**
	 * Entry point for the hook.
	 *
	 * @param array $params
	 * @param tslib_fe $pObj
	 * @return void
	 */
	public function process(array &$params, &$pObj) {
		try {
			$this->getLogger()->log(__METHOD__, 'processing');
			//$this->scrapeAssets($pObj);
			if ($pObj->isStaticCacheble()) {
				//$this->replaceAssets($pObj);
			}
		} catch(Exception $e) {
			$this->getLogger()->logException(__METHOD__, $e);
		}
	}
}