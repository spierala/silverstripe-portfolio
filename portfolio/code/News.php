<?php
class News extends DataObject {
    static $db = array(
        'Title' => 'Varchar',
        'ExternalLink' => 'Varchar',
        'OpenInNewWindow' => 'Boolean',
        'ShowInWidget' => 'Boolean'
    );
    
    static $has_one = array(
        'RelatedPage'=>'SiteTree'
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', new TextField('Title'));
        $externalLink = new TextField('ExternalLink');
        $externalLink->setDescription('e.g. http://www.mydomain.com');
        $fields->addFieldToTab('Root.Main', $externalLink);
        $fields->addFieldToTab('Root.Main', new TreeDropdownField('RelatedPageID', 'Choose Page', 'SiteTree'));
        $fields->addFieldToTab('Root.Main', new CheckboxField('OpenInNewWindow', 'Open link in new window'));
        $fields->addFieldToTab('Root.Main', new CheckboxField('ShowInWidget', 'Show news in News Widget'));
        return $fields;
    }
    
    public function getCustomLink() {
        $href = '';
        $target = '';
        if($this->OpenInNewWindow) {
            $target = 'target = "_blank"';
        }
        if($this->ExternalLink) {
            $href = 'href="'.$this->ExternalLink.'"';
        } elseif($this->RelatedPageID) {
            $page = SiteTree::get()->byID($this->RelatedPageID);
            if($page) {
                $href = 'href="'.$page->Link().'"';
            }
        }
        return '<a class="link" '.$target.' '.$href.'>'.$this->Title.'</a>';
    }
}
