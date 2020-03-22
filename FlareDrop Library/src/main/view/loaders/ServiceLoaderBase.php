<?php

if (WebConfigurationBase::$SYSTEM_WEBSERVICES_ENABLED) {


    if (WebConstants::getServiceName() == 'FileGet') {
        $service = new WebService('FileGet');
        $service->validate('GET', ['fileId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FilePrivateKeyGenerate') {
        $service = new WebService('FilePrivateKeyGenerate');
        $service->validate('POST', ['fileId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FilePrivateSet') {
        $service = new WebService('FilePrivateSet');
        $service->validate('POST', ['fileId', 'isPrivate']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FilesRemove') {
        $service = new WebService('FilesRemove');
        $service->validate('POST', ['fileIds']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FilesSet') {
        $service = new WebService('FilesSet');
        $service->validate('POST', ['fileType']);
        $service->filesValidate();
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FileUsedSpaceGet') {
        $service = new WebService('FileUsedSpaceGet');
        $service->validate('POST', ['type']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FolderGet') {
        $service = new WebService('FolderGet');
        $service->validate('POST', ['folderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FolderMove') {
        $service = new WebService('FolderMove');
        $service->validate('POST', ['sourceFolderId', 'destinationFolderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FolderRemove') {
        $service = new WebService('FolderRemove');
        $service->validate('POST', ['folderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FolderSet') {
        $service = new WebService('FolderSet');
        $service->validate('POST', ['folderData']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FoldersGet') {
        $service = new WebService('FoldersGet');
        $service->validate('POST', ['lanTag', 'diskId', 'getVisible', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'FoldersSort') {
        $service = new WebService('FoldersSort');
        $service->validate('POST', ['sortData']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectGet') {
        $service = new WebService('ObjectGet');
        $service->validate('POST', ['objectId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectSet') {
        $service = new WebService('ObjectSet');
        $service->validate('POST', ['objectData', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsGet') {
        $service = new WebService('ObjectsGet');
        $service->validate('POST', ['filterData', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsColumnsGet') {
        $service = new WebService('ObjectsColumnsGet');
        $service->validate('POST', ['filterData', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsCsvGet') {
        $service = new WebService('ObjectsCsvGet');
        $service->validate('GET', ['filterData', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsMove') {
        $service = new WebService('ObjectsMove');
        $service->validate('POST', ['ids', 'folderIdFrom', 'folderIdTo', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsLink') {
        $service = new WebService('ObjectsLink');
        $service->validate('POST', ['ids', 'folderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsUnlink') {
        $service = new WebService('ObjectsUnlink');
        $service->validate('POST', ['ids', 'folderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsRemove') {
        $service = new WebService('ObjectsRemove');
        $service->validate('POST', ['ids', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'ObjectsDuplicate') {
        $service = new WebService('ObjectsDuplicate');
        $service->validate('POST', ['ids', 'folderId', 'objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationFilterRemove') {
        $service = new WebService('SystemConfigurationFilterRemove');
        $service->validate('POST', ['objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationFilterSet') {
        $service = new WebService('SystemConfigurationFilterSet');
        $service->validate('POST', ['objectType', 'showDisk', 'diskDefault', 'showTextProperties', 'showPeriod']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationGet') {
        $service = new WebService('SystemConfigurationGet');
        $service->validate('POST');
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationListRemove') {
        $service = new WebService('SystemConfigurationListRemove');
        $service->validate('POST', ['listConfigurationId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationListSet') {
        $service = new WebService('SystemConfigurationListSet');
        $service->validate('POST', ['listConfigurationId', 'objectType', 'property', 'literalKey', 'formatType', 'width']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationMenuRemove') {
        $service = new WebService('SystemConfigurationMenuRemove');
        $service->validate('POST', ['objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationMenuSet') {
        $service = new WebService('SystemConfigurationMenuSet');
        $service->validate('POST', ['objectType', 'literalKey', 'iconClassName']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationObjectRemove') {
        $service = new WebService('SystemConfigurationObjectRemove');
        $service->validate('POST', ['objectType']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationObjectSet') {
        $service = new WebService('SystemConfigurationObjectSet');
        $service->validate('POST', ['objectType', 'bundle', 'foldersShow', 'folderOptionsShow', 'folderLevels', 'folderFilesEnabled', 'filesEnabled', 'folderPicturesEnabled', 'picturesEnabled', 'pictureDimensions', 'pictureQuality']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationPropertyRemove') {
        $service = new WebService('SystemConfigurationPropertyRemove');
        $service->validate('POST', ['propertiesConfigurationId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationPropertySet') {
        $service = new WebService('SystemConfigurationPropertySet');
        $service->validate('POST', ['propertiesConfigurationId', 'objectType', 'property', 'defaultValue', 'literalKey', 'type', 'localized', 'base64Encode', 'validate', 'validateCondition', 'validateErrorLiteralKey']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationCssRemove') {
        $service = new WebService('SystemConfigurationCssRemove');
        $service->validate('POST', ['cssConfigurationId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationCssSet') {
        $service = new WebService('SystemConfigurationCssSet');
        $service->validate('POST', ['cssConfigurationId', 'name', 'selector', 'styles']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationVarRemove') {
        $service = new WebService('SystemConfigurationVarRemove');
        $service->validate('POST', ['variable']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemConfigurationVarSet') {
        $service = new WebService('SystemConfigurationVarSet');
        $service->validate('POST', ['variable', 'name', 'value']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemPayPalPlanRenew') {
        $service = new WebService('SystemPayPalPlanRenew');
        $service->validate('POST');
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemSkinSet') {
        $service = new WebService('SystemSkinSet');
        $service->validate('POST', ['skin']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'UserLogin') {
        $service = new WebService('UserLogin');
        $service->validate('POST', ['xLOG1', 'xLOG2']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'UserLogout') {
        $service = new WebService('UserLogout');
        $service->validate('POST', ['diskId']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'UserPasswordReset') {
        $service = new WebService('UserPasswordReset');
        $service->validate('POST', ['name', 'userEmail', 'senderEmail', 'emailContentsBundle', 'emailSubjectKey', 'emailMessageKey']);
        $service->load();
    }

    if (WebConstants::getServiceName() == 'SystemTestingRun') {
        $service = new WebService('SystemTestingRun');
        $service->validate('POST');
        $service->load();
    }

    if (WebConstants::getServiceName() == 'TpvSignatureGet') {
        $service = new WebService('TpvSignatureGet');
        $service->validate('POST', ['tpvParameters']);
        $service->load();
    }
}
 