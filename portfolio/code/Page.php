<?php
require_once('phpmailer/class.phpmailer.php');
class Page extends SiteTree {
    //TODO: check Field Types, e.g. Text or better Varchar
    private static $db = array(
        'Subtitle' => 'Varchar(255)',
        'Location' => 'Varchar(100)',
        'Date' => 'Date',
        'ShowSocial' => 'Boolean',
        'ShowPageInFooter' => 'Boolean'
	);

    private static $defaults = array(
        'ShowSocial' => '1'
    );
    
    private static $has_one = array(
        'Author' => 'Member',
		'ImageFolder' => 'Folder',
        'ILikeCount' => 'ILikeCount'
	);
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('Location'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Subtitle'), 'Content');           

        $socialField = new CheckboxField('ShowSocial', 'Activate Social (Facebook sharing, interal iLike Counter)');
        $fields->addFieldToTab('Root.Main', $socialField, 'Content');

        $dateField = new DateField('Date');
        $dateField->setConfig('showcalendar', true);
        $dateField->setConfig('dateformat', 'dd.MM.YYYY');
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');

        $fields->addFieldToTab('Root.Main', new TreeDropdownField('ImageFolderID', 'Choose Image Folder', 'Folder'), 'Content');
        return $fields;
    }

    function getSettingsFields() {
        $fields = parent::getSettingsFields();
        $fields->addFieldToTab("Root.Settings", new CheckboxField('ShowPageInFooter'));
        return $fields;
    }

    //check dev mode, e.g. used to disable google analytics while developing locally in Page.ss
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

    public function AllPageCategories() {
        $categories = Category::get();
        return $categories;
    }

    public function AllBlogCategories() {
        $categories = BlogCategory::get();
        return $categories;
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

    public function getFooterPages() {
        return Page::get()->filter(array('ShowPageInFooter' => '1'));
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

    /* CACHING
    -------------------------------------------- */
    public function allPagesToCache() {
        // Get each page type to define its sub-urls
        $urls = array();

        // memory intensive depending on number of pages
        $pages = SiteTree::get()->where("ClassName != 'BlogEntry'"); //remove Blog pages from cache due to Form SecurityID issue

        foreach($pages as $page) {
            array_push($urls, $page->Link());
            if($page->ClassName == 'ProjectPage'){//add ajax pages for each projectpage
                array_push($urls, $page->Link().'ajax');
            }
        }
        return $urls;
    }

    function pagesAffectedByChanges() {
        $retArray = array();
        if($this->ClassName != 'BlogEntry'){ //ignore Blog Entry Pages
            array_push($retArray, $this->Link());
            array_push($retArray, $this->Parent()->Link());
            if($this->ClassName == 'ProjectPage'){ //add ajax pages for each projectpage
                array_push($retArray, $this->Link().'ajax');
            };
        }
        return $retArray;
    }

    /* WIDGETS
    -------------------------------------------- */
    public function getWidgetArea() {
        return SiteConfig::current_site_config()->WidgetArea();
    }

    /* MESSGAGES
    -------------------------------------------- */
    public function setCustomMessage($type, $message) {
        Session::set('CustomMessage', array(
            'MessageType' => $type,
            'Message' => $message
        ));
    }

    public function getCustomMessage() {
        if($message = Session::get('CustomMessage')){
            Session::clear('CustomMessage');
            $array = new ArrayData($message);
            return $array->renderWith('Message');
        }
    }

    /* AUTHOR
    -------------------------------------------- */
    function onBeforeWrite() {
        parent::onBeforeWrite();
        $this->AuthorID = Member::currentUserID();
    }

    public function getAuthorName(){
        $authorname = $this->Author()->FirstName . ' ' . $this->Author()->Surname;
        if($this->Author()->GooglePlusAuthorLink){
            return '<a target="_blank" href="'.$this->Author()->GooglePlusAuthorLink.'">'.$authorname.'</a>';
        }
        return $authorname;
    }

    /* OTHER
    -------------------------------------------- */
    public function getCurrentYear() {
        return date("Y");
    }

    public function testAjax(){
        if (Director::is_ajax()) {
            return 1;
        }else {
            return 0;
        }
    }
}


class Page_Controller extends ContentController {
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