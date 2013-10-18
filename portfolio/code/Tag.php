<?php
class Tag extends DataObject {
    static $db = array(
        'Name' => 'Varchar',
        'Slug' => 'Varchar',
        'Subtitle' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'HasTagPage' => 'Boolean'
    );

    static $has_one = array (
        'ILikeCount' => 'ILikeCount'
    );

    static $has_many = array (
        'Links' => 'Link'
    );

    static $belongs_many_many = array(
        'ProjectPages' => 'ProjectPage',
        'BlogEntries' => 'BlogEntry'
    );

    public function onBeforeWrite(){
        if($this->ILikeCount()!=null){
            $ilikeCount = new ILikeCount();
            $ilikeCount->write();
            $this->ILikeCountID = $ilikeCount->ID;
        }
        parent::onBeforeWrite();
    }

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeFieldFromTab('Root.Main', 'ILikeCountID');

        $tagpage = new CheckboxField('HasTagPage');
        $tagpage->setDescription('Generate Link to related Tag Page');
        $fields->addFieldToTab('Root.Main', $tagpage);
        return $fields;
    }
}
