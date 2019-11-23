<?php
defined('TYPO3_MODE') or die();

// Register actions-duplicate icon for TYPO3 8.x
if (version_compare(TYPO3_version, '9.0', '<')) {
    // Registers the icon
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $iconRegistry->registerIcon('actions-duplicate', \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class, [
        'source' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/actions-duplicate.svg'
    ]);
    $iconRegistry->registerIcon('actions-sort-amount-down', \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class, [
        'source' => 'EXT:sav_library_kickstarter/Resources/Public/Icons/actions-sort-amount-down.svg'
    ]);
}
?>
