<?php
class ArticlePage extends Page {
    private static $db = array(
        'Subtitle' => 'Varchar(255)',
        'Date' => 'Date',
        'Excerpt' => 'Text'
    );

    private static $has_one = array(
        'Author' => 'Member',
        'Location' => 'Location'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        //$fields->addFieldToTab('Root.Main', new TextField('Location'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Subtitle'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextareaField('Excerpt'), 'Content');

        $dateField = new DateField('Date');
        $dateField->setConfig('showcalendar', true);
        $dateField->setConfig('dateformat', 'dd.MM.YYYY');
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');

        $locationDropDown = new DropdownField('LocationID', 'Choose Location', $this->getLocationOptions());
        $locationDropDown->setEmptyString('(Select Location)');
        $locationDropDown->setDescription('Create new Locations in Model Admin');
        $fields->addFieldToTab('Root.Main', $locationDropDown, 'Content');

        return $fields;
    }

    /* LOCATION
    -------------------------------------------- */
    private function getLocationOptions() {
        if($Pages = DataObject::get('Location')) {
            return $Pages->map('ID', 'Title', 'Please Select');
        } else {
            return array('No Objects found');
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
}

class ArticlePage_Controller extends Page_Controller {

}