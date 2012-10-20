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
 * Member Placeholders - sets placeholders to chunks for group members
 * @package webinex
 * @subpackage snippets
 *
 * @param JSON groupChunks of the form {group : {placeholder : {"chunkName" : chunk-name, "properties" : {property : value}}}}
 * @param JSON default - placeholder chunks to set if user is not logged in, of the form
 * 		{placeholder : {"chunkName" : chunk-name, "properties" : {property : value}}}
 */

$groupChunks = $modx->getOption('groupChunks',$scriptProperties,'');
$default= $modx->getOption('default',$scriptProperties,'');

$chunkDataArray = $modx->fromJSON($groupChunks );
$defaultArray = $modx->fromJSON($default);

if($modx->user->isAuthenticated($modx->context->key)) {
	foreach($chunkDataArray as $group => $placeholders) {
		if($modx->user->isMember($group)) {
			foreach($placeholders as $placeholder => $chunkData) {
				$modx->setPlaceholder($placeholder, $modx->getChunk($chunkData['chunkName'],$chunkData['properties']));
			}
		}
	}
}else{
	foreach($defaultArray as $placeholder => $chunkData) {
		$modx->setPlaceholder($placeholder, $modx->getChunk($chunkData['chunkName'],$chunkData['properties']));
	}
}