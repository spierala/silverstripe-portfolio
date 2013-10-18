<?php

class Tag_Controller extends Page_Controller {
    private $tag = null;

    public static $allowed_actions = array('ilike' => true);

    public function index($arguments) {
        $this->Projects = new ArrayList();
        $slug = $arguments->param('Slug');
        $this->tag = Tag::get()->filter(array('Slug' => $slug))->First();
        if($this->tag){
            $this->Title = $this->tag->Name;
            $this->Subtitle = $this->tag->Subtitle;
            $this->Content = $this->tag->Content;
            $this->ProjectPages = $this->tag->ProjectPages();
            $this->Links = $this->tag->Links();
            return $this->renderWith(array('TagPage', 'Page'));
        }
    }

    //Counter
    public function ilike($arguments=null) {
        $slug = $arguments->param('Slug');
        $this->tag = Tag::get()->filter(array('Slug' => $slug))->First();
        $this->tag->ILikeCount()->countUp();
        return $this->tag->ILikeCount()->Count;
    }

    public function getCount() {
        return $this->tag->ILikeCount()->Count;
    }

    public function getFacebookLink() {
        return Director::absoluteBaseURL().'tag/'.$this->tag->Slug;
    }

    public function getIlikeLink() {
        return 'tag/ilike/'.$this->tag->Slug;
    }
}