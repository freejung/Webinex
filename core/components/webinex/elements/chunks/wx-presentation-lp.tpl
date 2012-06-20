<div id="right-column">
<p class="form-head">Please fill out the form below to register for this webinar.</p>
<div id="sc17014" class="form-wrapper">
<form method="post" name="register" action="[[~[[*id]]]]" id="registration-form">
<input value="[[+wx-referral-id]]" name="referralId" type="hidden"/>
<div id="form-element0" class="form-element"><label>Email Address<span>*</span></label><div class="form-input-wrapper"><input id="field0" value="" type="text" name="emailAddress" class=""/></div></div>
<div id="form-element1" class="form-element"><label>First Name<span>*</span></label><div class="form-input-wrapper"><input id="field1" value="" type="text" name="firstName" class=""/></div></div>
<div id="form-element2" class="form-element"><label>Last Name<span>*</span></label><div class="form-input-wrapper"><input id="field2" value="" type="text" name="lastName" class=""/></div></div>
<div id="form-element3" class="form-element"><label>Company</label><div class="form-input-wrapper"><input id="field3" value="" type="text" name="Company" class=""/></div></div>
<div id="form-element4" class="form-element"><label>Title</label><div class="form-input-wrapper"><input id="field4" value="" type="text" name="title" class=""/></div></div>
<div id="form-element5" class="form-element"><label>Business Phone</label><div class="form-input-wrapper"><input id="field5" value="" type="text" name="businessPhone" class=""/></div></div>
<div id="form-element6" class="form-element"><div class="form-input-wrapper"><input id="field6" value="[[+wx-affiliate-name]]" name="affiliateReferrer" type="hidden"/></div></div>
<div id="form-element7" class="form-element"><div class="form-input-wrapper"><input id="field7" value="" name="turing" type="hidden"/></div></div>
<div id="form-element8" class="form-element"><div class="form-input-wrapper"><input id="field8" class="submit-button" value="Register Now" type="submit"/></div></div></form>
<p class="form-foot"><span class="warning">*</span> required</p>
</div>
  [[!formIt? &hooks=`registerHook,redirect` &validate=`emailAddress:email:required, firstName:required, lastName:required, turing:blank` &redirectTo=`[[++webinex.registration_thanks_page]]` &redirectParams=`{"ps" : [[+id]]}`]]
</div>
<div id="left-column">
  <div id="lp-presentation">
<span class="webinar-head">
    <span class="wbn-full-date-lp" itemprop="startDate" datetime="[[+start-date-time:strtotime:date=`%FT%R%z`]]"><strong>[[+eventdate]], [[+starttime]] [[++date_timezone]]</strong></span>
   
    [[+wbn.introtext:notempty=`<span class="wbn-full-description" itemprop="description">[[+wbn.introtext]]</span>`]]
<span class="presenter-label">Presented by:</span>
<ul class="presenters-list">[[listPresenters? &presentation=`[[+id]]`]]</ul>
  </div></div>