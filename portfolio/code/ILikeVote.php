<?php
class ILikeVote extends DataObject {
	static $db = array(
		'Timestamp' => 'Int',
		'IP' => 'Text'
	);

    static $has_one = array(
        'ILikeCount' => 'ILikeCount'
    );
}
?>