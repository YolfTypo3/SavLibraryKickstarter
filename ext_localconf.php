<?php
defined('TYPO3_MODE') or die();

// Register actions-duplicate icon for TYPO3 9.x
// @todo Will be removed in TYPO3 11
if (version_compare(\YolfTypo3\SavLibraryKickstarter\Compatibility\Typo3VersionCompatibility::getVersion(), '10.0', '<')) {
    // Registers the icon
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon('actions-bolt', \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class, [
        'source' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/actions-bolt.svg'
    ]);
}
?>
