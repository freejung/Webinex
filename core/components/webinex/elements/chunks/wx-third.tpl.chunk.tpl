[[+recording:notempty=`
<li class="recording" itemscope itemtype="http://schema.org/VideoObject">
<a itemprop="url" href="[[+rec.url]]" [[+wbn.link_attributes]] target="_blank">
<span class="recording-link-span">
  <span class="recording-icon"></span>
  <span class="recording-text">
    <span itemprop="name" class="recording-title"> 
    [[+wbn.longtitle]]</span>
    <span itemprop="dateCreated" datetime="[[+eventdate:strtotime:date=`%FT%R%z`]]" class="recorded-date">Recorded [[+eventdate:strtotime:date=`%B %d, %Y`]]</span>
    <span itemprop="description" class="recording-subtitle">[[+wbn.description]]</span>
    <span class="recording-link">View Recording >></span>
  </span>
  </span>
  </a>
</li>
`:empty=`
<li class="uw-med" itemscope itemtype="http://schema.org/EducationEvent">
<a itemprop="url" href="[[~[[+wbn.id]]]]" [[+wbn.link_attributes]] target="_blank">
<span class="uw-med-link-span">
  <span class="uw-med-icon">[[listPresenters? &tpl=`wx-presenter-pic.tpl` &limit=`1` &presentation=`[[+id]]`]]</span>
  <span class="uw-med-text">
    <span itemprop="startDate" datetime="[[+eventdate:strtotime:date=`%FT%R%z`]]" class="uw-med-date">[[+eventdate:strtotime:date=`%B %d, %Y`]]</span>
    <span itemprop="name" class="uw-med-title">[[+wbn.longtitle]]</span>
    <span itemprop="description" class="uw-med-subtitle">[[+wbn.description]]</span>
    <span class="uw-med-link">Register Now >></span>
  </span>
  </span>
  </a>
</li>
`]]
