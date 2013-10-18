<?php
class BlogCategory_Controller extends Page_Controller {
    public $Projects;
    public $BlogCategoryID;
    public $SectionBlogCategory = 1;
    
    public function index($arguments) {
        $slug = $arguments->param('Slug');
        $blogcategory = BlogCategory::get()->filter(array('Slug' => $slug))->First();
        $this->Title = $blogcategory->Name;
        $this->BlogCategoryID = $blogcategory->ID;
        $this->Entries =  $blogcategory->BlogEntries()->sort('Date DESC');
        return $this->renderWith(array('BlogEntries', 'Page'));
    }

    private static $allowed_actions = array('index' => true);
}