<?php
require_once('phpmailer/class.phpmailer.php');
class Page extends BasicPage {
    private static $db = array(
        'ShowSocial' => 'Boolean'
	);

    private static $defaults = array(
        'ShowSocial' => '1'
    );
    
    private static $has_one = array(
		'ImageFolder' => 'Folder',
        'ILikeCount' => 'ILikeCount'
	);
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $socialField = new CheckboxField('ShowSocial', 'Show Social Box (Facebook sharing, internal iLike Counter)');
        $fields->addFieldToTab('Root.Main', $socialField, 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('ILikeCountCount', 'ILikeCount', $this->ILikeCount()->Count), 'Content');
        $fields->addFieldToTab('Root.Main', new TreeDropdownField('ImageFolderID', 'Choose Image Folder', 'Folder'), 'Content');
        return $fields;
    }

    //check dev mode
    public function InDevMode() {
        return (Director::isDev());
    }

    public function getFolderImages() {
        $templist = new ArrayList();
        $images = $this->ImageFolderID ? DataObject::get('Image', "ParentID = $this->ImageFolderID") : false;
        //remove first image from list which is used as preview in ProjectsPage.ss
        if($this->FirstImageIsPreview) {
            foreach($images as $image) {
                $templist->add($image);
            }
            $templist->shift();
            return $templist;
        }
        return $images;
    }

    public function nextPager() {
        $page = SiteTree::get()->filter(
            array(
                'Sort:GreaterThan' => $this->Sort,
                'ParentID' => $this->ParentID
            )
        )->sort('Sort ASC')->First();
        return $page;
    }

    public function previousPager() {
        $page = SiteTree::get()->filter(
            array(
                'Sort:LessThan' => $this->Sort,
                'ParentID' => $this->ParentID
            )
        )->sort('Sort DESC')->First();
        return $page;
    }

    /* FB
    -------------------------------------------- */
    public function getFacebookLink(){
        return $this->AbsoluteLink();
    }

    /* ILIKE COUNTER
    -------------------------------------------- */
    public function getIlikeLink() {
        return $this->Link().'/ilike';
    }

    public function countUp() {
        $this->ILikeCount()->countUp();
    }

    public function getCount() {
        if($this->ILikeCount()!=null){
            return $this->ILikeCount()->Count;
        }
        return -1;
    }

    public function onBeforeWrite() {
        //create iLike Counter if it does not yet exist
        if(!$this->ILikeCountID) {
            $ILikeCount = ILikeCount::create();
            $ILikeCount->Count = $this->ILikeCountCount;
            $ILikeCount->write();
            $this->ILikeCountID = $ILikeCount->ID;
        }
        //edit iLine Counter Count directly via TextField
        if($this->ILikeCountCount) {
            // update existing relation
            $ILikeCount = $this->ILikeCount();
            $ILikeCount->Count = $this->ILikeCountCount;
            $ILikeCount->write();
        }
        parent::onBeforeWrite();
    }
}


class Page_Controller extends BasicPage_Controller {
    private static $allowed_actions = array('ilike' => true);

    //Counter
    public function ilike($arguments = null) {
		$this->countUp();
        $this->republish($this->Link()); //trigger cache update //TODO: better use staticpublishqueue
		if($this->request->isAjax()) {
			return $this->getCount();
		}
	}

    //send mail via phpmailer
    public function sendCMSMail($to, $from, $from_name, $subject, $body) {
        global $error;
        $mail = new PHPMailer();  // create a new object
        $mail->CharSet  =  'utf-8'; //UTF-8 Kodierung festlegen
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true;  // authentication enabled
        $mail->Host = Page::config()->host;
        $mail->Port = Page::config()->port;
        $mail->Username = Page::config()->username;
        $mail->Password = Page::config()->password;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
        $mail->IsHTML(true);
        $mail->Body = $body;

        $mail->AddAddress($to);
        if(!$mail->Send()) {
            $error = 'Mail error: '.$mail->ErrorInfo; 
            return false;
        } else {
            $error = 'Message sent!';
            return true;
        }
    }
}