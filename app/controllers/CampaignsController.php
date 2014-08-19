<?php

class CampaignsController extends BaseController {

	public function getIndex()
	{
		$campaigns = Campaign::where('user_id', Auth::user()->user_id)->get();
		$this->layout->content = View::make('campaigns.index')->with('campaigns', $campaigns);
	}

	public function getShow($id) {
		return $id;
	}

	public function deleteDestroy($id) {
        $Campaign = Campaign::find($id);
        $Campaign->delete();
        return Redirect::to('Campaign')->with('success', 'Campaign successfully deleted!');
    }

}
