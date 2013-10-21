<?php

class NewsWidget extends GeneralWidget {
    static $cmsTitle = 'News';
    static $description = 'Display News which are created in PortfolioModelAdmin with ShowInHeader activated';

    public function Content() {
        return null;
    }

    public function getNews(){
        $news = News::get()->filter(array('ShowInWidget' => 1));
        return $news;
    }

    public function getCMSFields() {
        return new FieldList(
            new TextField('Title'),
            new TextField('CssClass')
        );
    }
}

class NewsWidgetController extends Widget_Controller {
    //use custom template
    public function Content() {
        return $this->renderWith('NewsWidget');
    }
}

?>