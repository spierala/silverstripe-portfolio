<?php
  class CustomSiteConfig extends DataExtension {
    static $db = array(
        'Location' => 'Text',
        'LocationLabel' => 'Text'
    );

    static $has_one = array(
        'WidgetArea' => 'WidgetArea',
        'TitleImage' => 'Image'
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new TextField('Location', 'Location'));
        $fields->addFieldToTab('Root.Main', new TextField('LocationLabel', 'Location Label'));
        $fields->addFieldToTab('Root.Main', new UploadField('TitleImage'));
        $fields->addFieldToTab('Root.Widgets', new WidgetAreaEditor('WidgetArea'));
        return $fields;
    }
}