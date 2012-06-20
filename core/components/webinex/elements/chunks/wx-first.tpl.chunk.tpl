<li class="upcoming-webinar" itemscope itemtype="http://schema.org/EducationEvent" class="resource-container">
  <span class="resource-icon"></span>  
<span class="webinar-head">
    <span class="wbn-full-date" itemprop="startDate" datetime="[[+eventdate:strtotime:date=`%FT%R%z`]]"><strong>[[+eventdate:strtotime:date=`%A %B %d, %Y, %I:%M %P`]] [[++date_timezone]]</strong></span>
    <span class="webinar-title"><a target="_blank" itemprop="url" href="[[~[[+wbn.id]]]]" [[+wbn.link_attributes]] title="Register for [[+wbn.longtitle]]"><span itemprop="name"> [[+wbn.longtitle]]</span></a></span></span>
    [[+wbn.description:notempty=`<span class="wbn-subtitle">[[+wbn.description]]</span>`]]
    [[+wbn.introtext:notempty=`<span class="wbn-full-description" itemprop="description">[[+wbn.introtext]]</span>`]]
<span class="presenter-label">Presented by:</span>
<ul class="presenters-list">[[listPresenters? &presentation=`[[+id]]`]]</ul>
<span class="wbn-reg-button"><a target="_blank" href="[[~[[+wbn.id]]]]" [[+wbn.link_attributes]] title="Register for [[+wbn.pagetitle]]">Register Now</a></span>
</li>

