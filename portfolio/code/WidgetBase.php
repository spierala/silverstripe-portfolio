<?php
class WidgetBase extends Widget{
    static $db = array(
        'Title' => 'Varchar',
        'CssClass' => 'Varchar'
    );

    public function getCMSFields() {
        return new FieldList(
            new TextField('Title'),
            new TextField('CssClass', 'Icon Css Class')
        );
    }

    public function getCustomTitle(){
        return $this->Title;
    }
}