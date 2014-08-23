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
        $campaign = Campaign::find($id);
        File::delete(public_path() . '/uploads/'. $campaign->csv);
        $campaign->delete();
        return Redirect::to('campaign')->with('success', 'Campaign successfully deleted!');
    }

}
