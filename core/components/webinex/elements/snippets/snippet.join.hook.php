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
 * Join hook for register snippet - set registrants class key to wxProspect
 * @package webinex
 * @subpackage snippets
 */
if(!$hook) return FALSE;
$user = $hook->getValue('register.user');
$profile = $hook->getValue('register.profile');
$user->set('class_key', 'wxProspect');
if($hook->getValue('firstName') || $hook->getValue('lastName')) $profile->set('fullname',$hook->getValue('firstName').' '.$hook->getValue('lastName'));
$saved = $user->save();
return TRUE;