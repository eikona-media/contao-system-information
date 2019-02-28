<?php

// implement js-/css-files in backend
if (TL_MODE === 'BE') {
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/eikonamediacontaosysteminformation/js/systemInfo.js';
    $GLOBALS['TL_CSS'][] = 'bundles/eikonamediacontaosysteminformation/css/systemInfo.css';
}

// Hooks
$GLOBALS['TL_HOOKS']['getUserNavigation'][] = ['eikona_media.contao.system_information.listener.navigation', 'onGetUserNavigation'];

// Backend Module for Permissions
$GLOBALS['BE_MOD']['system']['system_information'] = [];
