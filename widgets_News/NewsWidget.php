<?php

class NewsWidget extends Widget {
    static $db = array(
        "Title" => "Varchar"
    );

    static $cmsTitle = "News";   
    static $description = "Display News which are created in PortfolioModelAdmin with ShowInHeader activated";

    public function Title(){
        return $this->Title;
    }

    public function getNews(){
        $news = News::get()->filter(array('ShowInHeader' => 1));
        return $news;
    }

    public function getCMSFields() {
        return new FieldList(
            new TextField("Title", "Title")
        );
    }
}

?>