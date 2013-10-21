<?php

class NewsWidget extends WidgetBase {
    static $cmsTitle = 'News';
    static $description = 'Display News created in ModelAdmin with ShowInWidget activated';

    public function getNews(){
        $news = News::get()->filter(array('ShowInWidget' => 1));
        return $news;
    }
}

class NewsWidgetController extends Widget_Controller {
    //use custom template
    public function Content() {
        return $this->renderWith('NewsWidget');
    }
}

?>