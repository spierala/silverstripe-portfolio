<?php
class BasicPage extends SiteTree {
    private static $description = 'Has no content-sidebar and a basic content-header';

    private static $db = array(
        'ShowPageInFooter' => 'Boolean'
    );

    function getSettingsFields() {
        $fields = parent::getSettingsFields();
        $fields->addFieldToTab("Root.Settings", new CheckboxField('ShowPageInFooter'));
        return $fields;
    }

    public function getFooterPages() {
        return BasicPage::get()->filter(array('ShowPageInFooter' => '1'));
    }

    /* Main Navigation
    -------------------------------------------- */
    /* ProjectPage Categories in Main Navigation */
    public function AllPageCategories() {
        $categories = Category::get();
        return $categories;
    }

    /* BlogEntry Categories in Main Navigation */
    public function AllBlogCategories() {
        $categories = BlogCategory::get();
        return $categories;
    }

    /* WIDGETS
    -------------------------------------------- */
    public function getWidgetArea() {
        return SiteConfig::current_site_config()->WidgetArea();
    }

    /* CACHING
    -------------------------------------------- */
    public function allPagesToCache() {
        // Get each page type to define its sub-urls
        $urls = array();

        // memory intensive depending on number of pages
        $pages = SiteTree::get()->where("ClassName != 'BlogEntry'"); //remove Blog pages from cache due to Form SecurityID issue

        foreach($pages as $page) {
            array_push($urls, $page->Link());
            if($page->ClassName == 'ProjectPage'){//add ajax pages for each projectpage
                array_push($urls, $page->Link().'ajax');
            }
        }
        return $urls;
    }

    function pagesAffectedByChanges() {
        $retArray = array();
        if($this->ClassName != 'BlogEntry'){ //ignore Blog Entry Pages
            array_push($retArray, $this->Link());
            array_push($retArray, $this->Parent()->Link());
            if($this->ClassName == 'ProjectPage'){ //add ajax pages for each projectpage
                array_push($retArray, $this->Link().'ajax');
            };
        }
        return $retArray;
    }

    /* MESSGAGES
    -------------------------------------------- */
    public function setCustomMessage($type, $message) {
        Session::set('CustomMessage', array(
            'MessageType' => $type,
            'Message' => $message
        ));
    }

    public function getCustomMessage() {
        if($message = Session::get('CustomMessage')){
            Session::clear('CustomMessage');
            $array = new ArrayData($message);
            return $array->renderWith('Message');
        }
    }


    /* OTHER
    -------------------------------------------- */
    public function getCurrentYear() {
        return date("Y");
    }

    public function testAjax(){
        if (Director::is_ajax()) {
            return 1;
        }else {
            return 0;
        }
    }
}

class BasicPage_Controller extends ContentController {

}