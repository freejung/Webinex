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
 * CMP homepage
 * @package webinex
 * @subpackage controllers
 */
class WebinexHomeManagerController extends WebinexManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('webinex'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/presenters.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/documents.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/companies.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/affiliates.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/videos.grid.js');
        $this->addJavascript($this->webinex->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->webinex->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() { return $this->webinex->config['templatesPath'].'home.tpl'; }
}