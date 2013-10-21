<?php
class ArticlePage extends Page {
    private static $db = array(
        'Subtitle' => 'Varchar(255)',
        'Location' => 'Varchar(100)',
        'Date' => 'Date',
        'Excerpt' => 'Text'
    );

    private static $has_one = array(
        'Author' => 'Member'
    );

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('Location'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Subtitle'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextareaField('Excerpt'), 'Content');

        $dateField = new DateField('Date');
        $dateField->setConfig('showcalendar', true);
        $dateField->setConfig('dateformat', 'dd.MM.YYYY');
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');

        return $fields;
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