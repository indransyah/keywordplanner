<?php

class HelpController extends BaseController {

	public function getIndex()
	{
		$this->layout->content = View::make('helps.keywordplanner');
	}

}
