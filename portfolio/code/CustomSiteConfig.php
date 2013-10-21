<?php
  class CustomSiteConfig extends DataExtension {
    static $has_one = array(
        'WidgetArea' => 'WidgetArea',
        'TitleImage' => 'Image'
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Main', new UploadField('TitleImage'));
        $fields->addFieldToTab('Root.Widgets', new WidgetAreaEditor('WidgetArea'));
        return $fields;
    }
}