<?php

/* @var modX $modx
 * @var array $scriptProperties
 **/

$resourceId = $modx->getOption('content_id',$scriptProperties, null);
$versionId = $modx->getOption('version_id',$scriptProperties, null);

if (!$resourceId || !$versionId) {
    return $modx->error->failure('Resource or Version ID not specified.');
}

/* @var vxResource $version */
$version = $modx->getObject('vxResource',array(
    'content_id' => (int)$resourceId,
    'version_id' => (int)$versionId
));

if (!($version instanceof vxResource)) {
    return $modx->error->failure('Requested Version not found.');
}

if (!$modx->haspermission('delete_document')) {
	return $modx->error->failure($modx->lexicon('permission_denied'));
}

if (!$version->remove()) {
    return $modx->error->failure('An error occured while removing the version.');
} else {
   $modx->logManagerAction('vxresource/remove',$version->get('class'),$version->get('title') .  '(' . $version->get('content_id') . ' => ' . $versionId . ')');
}

return $modx->error->success();
