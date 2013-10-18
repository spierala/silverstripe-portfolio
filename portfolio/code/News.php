<?php
class News extends DataObject {
    static $db = array(
        'Title' => 'Varchar',
        'OpenInNewWindow' => 'Boolean',
        'Link' => 'Varchar',
        'ShowInHeader' => 'Boolean'
    );
    
    static $has_one = array(
        'RelatedPage'=>'SiteTree'
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();           
        $fields->addFieldToTab('Root.Main', new TreeDropdownField('RelatedPageID', 'Seite wählen', 'SiteTree'));
        return $fields;
    }
    
    public function getCustomLink() {
        $href = '';
        $target = '';
        if($this->OpenInNewWindow) {
            $target = 'target = #_blank#';
        }
        if($this->Link) {
            $href = 'href="'.$this->Link.'"';
        } elseif($this->RelatedPageID) {
            $page = SiteTree::get()->byID($this->RelatedPageID);
            if($page) {
                $href = 'href="'.$page->Link().'"';
            }
        }
        return "<a class='link' ".$target." ".$href.">$this->Title</a>";
    }
}
