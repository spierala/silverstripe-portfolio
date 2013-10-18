<?php

class Category_Controller extends Page_Controller {
    public $Projects;
    public $CategoryID;
    public $SectionProjectCategory = 1; 

    public function index($arguments) {
        $this->Projects = new ArrayList();
        $slug = $arguments->param('Slug');
        $category = Category::get()->filter(array('Slug' => $slug))->First();
        if($category) {
            $this->Title = $category->Name;
            $this->CategoryID = $category->ID;

            $projectsOfCategory = $category->ProjectPages()->sort('Sort', 'ASC');
            foreach ($projectsOfCategory as $project) {
                $this->Projects->add($project);
            }
            $otherProjects = DataObject::get('ProjectPage')->sort('Sort', 'ASC')->subtract($projectsOfCategory);
            $this->OtherProjects = new ArrayList();
            foreach ($otherProjects as $otherproject) {
                $otherproject->knockout = 1;
                $this->OtherProjects->add($otherproject);
            }
            return $this->renderWith(array('ProjectsPage', 'Page'));
        }else {
            return $this->httpError(404);
        }
    }
}