<?php
class PortfolioModelAdmin extends ModelAdmin {
    public static $managed_models = array('News', 'Comment', 'Category', 'Tag', 'AttributeLabel', 'Location');
    static $url_segment = 'portfolio-model-admin';
    static $menu_title = 'ModelAdmin';
}