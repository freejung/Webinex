<?php
function getSnippetContent($filename) {
    $o = file_get_contents($filename);
    $o = trim(str_replace(array('<?php','?>'),'',$o));
    return $o;
}
$snippets = array();
 
$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'affiliateId',
    'description' => 'Identifies an affiliate referral by an affiliate id URL parameter.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.affiliate.id.php'),
),'',true,true);

$snippets[2]= $modx->newObject('modSnippet');
$snippets[2]->fromArray(array(
    'id' => 2,
    'name' => 'getWebinars',
    'description' => 'Displays a list of webinars.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.get.webinars.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.get.webinars.php';
$snippets[2]->setProperties($properties);

$snippets[3]= $modx->newObject('modSnippet');
$snippets[3]->fromArray(array(
    'id' => 3,
    'name' => 'listPresenters',
    'description' => 'Displays a list of webinar presenters.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.list.presenters.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.list.presenters.php';
$snippets[3]->setProperties($properties);

$snippets[4]= $modx->newObject('modSnippet');
$snippets[4]->fromArray(array(
    'id' => 4,
    'name' => 'Now',
    'description' => 'Returns the current date/time.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.now.php'),
),'',true,true);

$snippets[5]= $modx->newObject('modSnippet');
$snippets[5]->fromArray(array(
    'id' => 5,
    'name' => 'listPresentations',
    'description' => 'Displays a list of webinar presentations.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.list.presentations.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.list.presentations.php';
$snippets[5]->setProperties($properties);

$snippets[6]= $modx->newObject('modSnippet');
$snippets[6]->fromArray(array(
    'id' => 6,
    'name' => 'resubmitHook',
    'description' => 'Formit post hook to resubmit the form to an external URL specified in script properties.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.resubmit.hook.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.resubmit.hook.php';
$snippets[6]->setProperties($properties);

$snippets[7]= $modx->newObject('modSnippet');
$snippets[7]->fromArray(array(
    'id' => 7,
    'name' => 'registerHook',
    'description' => 'Records the event of registering for a webinar, creating a new Prospect user if one does not exist, and recording the affiliate referral if any.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.register.hook.php'),
),'',true,true);

$snippets[8]= $modx->newObject('modSnippet');
$snippets[8]->fromArray(array(
    'id' => 8,
    'name' => 'UTCDate',
    'description' => 'Output filter similar to the date output filter, except it returns the UTC date/time instead of the local date/time.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.utcdate.php'),
),'',true,true);

$snippets[9]= $modx->newObject('modSnippet');
$snippets[9]->fromArray(array(
    'id' => 9,
    'name' => 'listDocuments',
    'description' => 'Displays a list of webinar attachment documents.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.list.documents.php'),
),'',true,true);
$properties = include $sources['data'].'properties/properties.list.documents.php';
$snippets[9]->setProperties($properties);

$snippets[10]= $modx->newObject('modSnippet');
$snippets[10]->fromArray(array(
    'id' => 10,
    'name' => 'presentationId',
    'description' => 'Simple snippet to get the presentation id from the GET parameter ps',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.presentation.id.php'),
),'',true,true);

$snippets[11]= $modx->newObject('modSnippet');
$snippets[11]->fromArray(array(
    'id' => 11,
    'name' => 'localTime',
    'description' => 'Simple snippet to convert the presentation time into the visitor local time',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.local.time.php'),
),'',true,true);

$snippets[12]= $modx->newObject('modSnippet');
$snippets[12]->fromArray(array(
    'id' => 12,
    'name' => 'listAffiliates',
    'description' => 'Displays a list of affiliates.',
    'snippet' => getSnippetContent($sources['elements'].'snippets/snippet.list.affiliates.php'),
),'',true,true);

unset($properties);
 
return $snippets;