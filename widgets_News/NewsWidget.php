<?php

class NewsWidget extends Widget {
    static $db = array(
        "Title" => "Varchar",
        "CssClass" => "Varchar"
    );

    static $cmsTitle = "News";

    public function Title(){
        return $this->Title;
    }

    public function getNews(){
        $news = News::get()->filter(array('ShowInHeader' => 1));
        return $news;
    }

    public function getCMSFields() {
        return new FieldList(
            new TextField("Title", "Title"),
            new TextField("CssClass", "CssClass")
        );
    }
}

?>