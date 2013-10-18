<?php
class ILikeCount extends DataObject {
	static $db = array(
		'Count' => 'Int'
	);

    static $has_many = array (
        'ILikeVotes' => 'ILikeVote'
    );

    public function countUp() {
        if(!isset($_COOKIE['liked-' . $this->ID]) && Session::get('liked-' . $this->ID) == false){
            Session::set('liked-' . $this->ID, 'true'); //block revoting via session
            setcookie('liked-'.$this->ID, time(), time()+3600*24*365, '/'); //block revoting via cookie, cookie will live for one year
            if($this->checkIpVoted()==false){ //block revoting via ip tracking in DB (for the case cookies are disabled in the browser) - see function checkIpVoted();
                //record the vote and write it to the DB
                $vote = new ILikeVote();
                $vote->ILikeCountID = $this->ID;
                $vote->Timestamp = time(); //save time of the vote (UNIX timestamp)
                $vote->IP = $_SERVER['REMOTE_ADDR']; //save IP of the user
                $vote->write();
                //increment the counter
                $this->Count++;
                $this->write();
            }
        }
    }

    private function checkIpVoted() {
        $time = time(); //get current time (UNIX timestamp)
        $timeLimit = $time - 600; //600 means: after 10 min the same ip could vote again
        $votes = $this->ILikeVotes()->filter(array(
            'IP' => $_SERVER['REMOTE_ADDR'],
            'Timestamp:GreaterThan' => $timeLimit
        ));
        if($votes->count()>0){
            return true;
        };
        return false;
    }
}
?>