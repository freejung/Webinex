BEGIN:VCALENDAR
VERSION:2.0
METHOD:PUBLISH
BEGIN:VEVENT
DTSTART:[[+start-date-time:strtotime:UTCDate=`%Y%m%d`]]T[[+start-date-time:strtotime:UTCDate=`%H%M%S`]]Z
DURATION:PT1H0M0S
LOCATION;ENCODING=QUOTED-PRINTABLE:Webinar
UID:[[!Now? &format=`%Y%m%d` &local=`0`]]T[[!Now? &format=`%H%M%S` &local=`0`]]Z@[[++site_url]]
DTSTAMP:[[!Now? &format=`%Y%m%d` &local=`0`]]T[[!Now? &format=`%H%M%S` &local=`0`]]Z
DESCRIPTION:1. Click this link to join the Webinar:\n\n   [[+joinurl]]\n\n\n
SUMMARY;ENCODING=QUOTED-PRINTABLE:[[+wbn.longtitle]]
BEGIN:VALARM
TRIGGER:-PT15M
ACTION:DISPLAY
DESCRIPTION:Reminder
END:VALARM
END:VEVENT
END:VCALENDAR
