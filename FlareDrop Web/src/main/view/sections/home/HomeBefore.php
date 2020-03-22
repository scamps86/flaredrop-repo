<?php
// Meta description array
$metaDescriptionArray = [];

// Define the sliders content
$slider = [];

for ($i = 0; $i < 9; $i++) {

    $picFileName = '';

    switch ($i) {
        case 0:
            $picFileName = 'web-manage.png';
            break;
        case 1:
            $picFileName = 'web-ideas.png';
            break;
        case 2:
            $picFileName = 'web-seo.png';
            break;
        case 3:
            $picFileName = 'web-architecture.png';
            break;
        case 4:
            $picFileName = 'web-multilanguage.png';
            break;
        case 5:
            $picFileName = 'web-shop.png';
            break;
        case 6:
            $picFileName = 'web-responsive.png';
            break;
        case 7:
            $picFileName = 'web-hosting-domain.png';
            break;
        case 8:
            $picFileName = 'web-google-analytics.png';
            break;
    }

    $htmlContent = '<div class="slide"><h1 class="title fontThin">' . Managers::literals()->get('SLIDER_TITLE_' . $i, 'Home') . '</h1>';
    $htmlContent .= '<div class="row"><h2 class="fontLight">' . Managers::literals()->get('SLIDER_SUBTITLE_' . $i, 'Home') . '</h2></div>';
    $htmlContent .= '<div class="row"><img src="' . UtilsHttp::getRelativeUrl('view/resources/images/home/' . $picFileName) . '" alt="' . Managers::literals()->get('SLIDER_TITLE_' . $i, 'Home') . '" /></div></div>';

    array_push($slider, $htmlContent);
    array_push($metaDescriptionArray, Managers::literals()->get('SLIDER_TITLE_' . $i, 'Home'));
}

shuffle($slider);
shuffle($metaDescriptionArray);

// Get last 6 works
$filter = new VoSystemFilter();
$filter->setPageCurrent(0);
$filter->setPageNumItems(6);
$filter->setRandom(6);
$filter->setRootId(WebConfigurationBase::$ROOT_ID);
$filter->setAND();
$filter->setDiskId(WebConfigurationBase::$DISK_WEB_ID);
$filter->setAND();
$filter->setPropertyMatch('visible', '1');
$filter->setAND();
$filter->setPropertyMatch('showHome', '1');
$filter->setAND();
$filter->setLanTag(WebConstants::getLanTag());

$works = SystemDisk::objectsGet($filter, 'Work');

// Meta tags
$metaDescription = '';

foreach ($metaDescriptionArray as $m) {
    $metaDescription .= $m . ' ';
}

self::addMetaDescription(substr($metaDescription, 0, -1));

