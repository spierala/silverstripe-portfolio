<?php
class ProjectPage extends Page { 
    static $db = array(
        'Excerpt' => 'Text',
        'FirstImageIsPreview' => 'Boolean'
	);
    static $has_many = array(
        'ProjectAttributes' => 'ProjectAttribute'
    );
    static $many_many = array(
        'Categories' => 'Category',
        'Tags' => 'Tag'
    );
    
    public function getCMSFields() {
        $fields = parent::getCMSFields();   
        $categoriesField = new GridField(
            'Categories',
            'Categories',
            $this->Categories(),
            GridFieldConfig_RelationEditor::create()
        );            
        $fields->addFieldToTab('Root.Categories', $categoriesField);
        
        $tagsField = new GridField(
            'Tags',
            'Tags',
            $this->Tags(),
            GridFieldConfig_RelationEditor::create()
        );            
        $fields->addFieldToTab('Root.Tags', $tagsField);
        
        $attributesField = new GridField(
            'ProjectAttributes',
            'ProjectAttributes',
            $this->ProjectAttributes(),
            GridFieldConfig_RelationEditor::create()
        ); 
        $fields->addFieldToTab('Root.ProjectAttributes', $attributesField);
        $dateField = new DateField('Date');
        $dateField->setConfig('showcalendar', true);
        $dateField->setConfig('dateformat', 'dd.MM.YYYY');
        $fields->addFieldToTab('Root.Main', new TextareaField('Excerpt'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Location'), 'Content');
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');

        $firstImageField = new CheckboxField('FirstImageIsPreview', 'Ignore First Image of Image Folder');
        $fields->addFieldToTab('Root.Main', $firstImageField, 'ImageFolderID');
        return $fields;
    }
    
    public function getCategoriesDataAttribute() {
        $tempArray = array();
        foreach($this->Categories() as $category){
            array_push($tempArray, '"'.$category->Slug.'"');
        };
        return implode(',', $tempArray);
    }
    
    public function getProjectCategories() {
        return $this->Categories();
    }
    
    function getFirstFolderImage() { 
		return $this->ImageFolderID ? DataObject::get('Image', "ParentID = $this->ImageFolderID")->First() : false;
	}
    
}
class ProjectPage_Controller extends Page_Controller {
    public static $allowed_actions = array('ajax' => true);

    public function ajax() {
        return $this->renderWith('ProjectPage');
    }
}