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

        $socialField = new CheckboxField('ShowSocial', 'Activate Social (Facebook sharing, interal iLike Counter)');
        $fields->addFieldToTab('Root.Main', $socialField, 'Content');
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
            return $images;
        }
        return $images;
    }
    
    public function nextPager() {
		$where = "ParentID = ($this->ParentID + 0) AND Sort > ($this->Sort + 0 )";
		$pages = DataObject::get("SiteTree", $where, "Sort", "", 1);
		if($pages) {
			foreach($pages as $page) {
				return $page;
			}
		}
	}
	public function previousPager() {
		$where = "ParentID = ($this->ParentID + 0) AND Sort < ($this->Sort + 0)";
		$pages = DataObject::get("SiteTree", $where, "Sort DESC", "", 1);
		if($pages) {
			foreach($pages as $page) {
				return $page;
			}
		}
	}

    /* FB
    -------------------------------------------- */
    public function getFacebookLink(){
        return $this->AbsoluteLink();
    }

    /* ILIKE COUNTER
    -------------------------------------------- */
    public function getIlikeLink() {
        return $this->URLSegment.'/ilike';
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

    //create an ilike counter after publishing page
    public function onAfterPublish() {
        if($this->ShowSocial == 1){
            if($this->ILikeCount()!=null){
                $ilikeCount = new ILikeCount();
                $ilikeCount->write();
                $this->ILikeCountID = $ilikeCount->ID;
                $this->writeToStage('Stage');
                $this->publish('Stage', 'Live');
            }
        }
    }
}


class Page_Controller extends BasicPage_Controller {
    private static $allowed_actions = array('ilike' => true);

    //Counter
    public function ilike($arguments = null) {
		$this->countUp();
        $this->republish($this->Link()); //trigger cache update //TODO: is this good?
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
        $mail->Host = $this->config()->host;
        $mail->Port = $this->config()->port;
        $mail->Username = $this->config()->username;
        $mail->Password = $this->config()->password;
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