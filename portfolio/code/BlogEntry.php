<?php
class BlogEntry extends ArticlePage {
    static $has_many = array(
        'Comments' => 'Comment'
    );
    
    static $many_many = array(
        'BlogCategories' => 'BlogCategory',
        'Tags' => 'Tag'
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();   
        $categoriesField = new GridField(
            'BlogCategories',
            'BlogCategories',
            $this->BlogCategories(),
            GridFieldConfig_RelationEditor::create()
        );            
        $fields->addFieldToTab('Root.BlogCategories', $categoriesField);
        
        $tagsField = new GridField(
            'Tags',
            'Tags',
            $this->Tags(),
            GridFieldConfig_RelationEditor::create()
        );            
        $fields->addFieldToTab('Root.Tags', $tagsField);
                
        return $fields;
    }

    //Override Pagers of Page.php
    public function nextPager() {
        $page = BlogEntry::get()->filter(
            array(
                'Date:LessThan' => $this->Date,
                'ParentID' => $this->ParentID
            )
        )->sort('Date DESC')->First();
        return $page;
    }

    public function previousPager() {
        $page = BlogEntry::get()->filter(
            array(
                'Date:GreaterThan' => $this->Date,
                'ParentID' => $this->ParentID
            )
        )->sort('Date')->First();
        return $page;
    }
}

class BlogEntry_Controller extends ArticlePage_Controller {
    public static $allowed_actions = array('CommentForm' => true);

    public function CommentForm(){
        return new CommentForm($this, 'CommentForm'); 
    }
    
    public function getApprovedComments(){
        $comments = $this->Comments()->filter(array('Approved' => '1')); 
        return $comments;           
    }
}