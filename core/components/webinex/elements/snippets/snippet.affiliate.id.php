<?php
/**
 * Webinex
 *
 * Copyright 2012 by Eli Snyder <freejung@gmail.com>
 *
 * Webinex is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Webinex is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Webinex; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package webinex
 */
/**
 * Affiliate ID snippet
 * @package webinex
 * @subpackage snippets
 */
if(!filter_has_var(INPUT_GET, 'ai')){
  return '';
}else{
  if (!filter_input(INPUT_GET, "ai", FILTER_VALIDATE_INT)){
     return '';
  }else{
    $affiliateCode = $_GET['ai'];
  }
}

$resource = $modx->resource;
if($affiliateCode){
    if($affiliate = $modx->getObject('wxAffiliate', array('code' => $affiliateCode))){
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
return '';