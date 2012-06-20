<?php
if(!filter_has_var(INPUT_GET, 'ai')){
  return '';
}else{
  if (!filter_input(INPUT_GET, "ai", FILTER_VALIDATE_INT)){
     return '';
  }else{
    $affiliateCode = $_GET['ai'];
  }
}

$affiliates = $modx->getCollection('wxAffiliate');
$resource = $modx->resource;

foreach ($affiliates as $affiliate) {
    if($affiliate->get('code') == $affiliateCode) {
        $referral = $modx->newObject('wxReferral');
        $referral->addOne($affiliate);
        $referral->set('entry',$resource->id);
        $referral->set('createdon',time());
        if($modx->user->isAuthenticated($modx->context->key)) {
            $user = $modx->user;
            if($user->class_key == wxProspect) {
                $referral->addOne($user);
            }
        }
        $referral->save();
        $_SESSION['wxReferralId'] = $referral->id;
        $modx->setPlaceholder('wx-affiliate-name', $affiliate->name);
        $modx->setPlaceholder('wx-affiliate-code', $affiliateCode);
        $modx->setPlaceholder('wx-affiliate-logo', $affiliate->logo); 
        $modx->setPlaceholder('wx-affiliate-state', $affiliate->state); 
        $modx->setPlaceholder('wx-referral-id', $referral->id);      
    }
}
return'';
