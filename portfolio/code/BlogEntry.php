<?php
class BlogEntry extends Page { 
     static $db = array(
        'Excerpt' => 'Text'
	);
     
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
        
//        $commentsField = new GridField(
//            'Comments',
//            'Comments',
//            $this->Comments(),
//            GridFieldConfig_RelationEditor::create()
//        );            
//        $fields->addFieldToTab('Root.Comments', $commentsField);
        
        $fields->addFieldToTab('Root.Main', new TextareaField('Excerpt'), 'Content');
                
        return $fields;
    }
}

class BlogEntry_Controller extends Page_Controller {
    public static $allowed_actions = array('CommentForm' => true);

    public function CommentForm(){
        return new CommentForm($this, 'CommentForm'); 
    }
    
    public function getApprovedComments(){
        $comments = $this->Comments()->filter(array('Approved' => '1')); 
        return $comments;           
    }
}