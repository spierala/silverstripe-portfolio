<?php
class BasicPage extends SiteTree {
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

        //add tag pages
        $tags = Tag::get()->filter(array('HasTagPage' => 1));
        foreach($tags as $tag) {
            array_push($urls, '/tag/'.$tag->Slug);
        }

        //add location pages
        $locations = Location::get();
        foreach($locations as $location) {
            array_push($urls, '/location/'.$location->Slug);
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
}

class BasicPage_Controller extends ContentController {
    private $strava_webservice;

    private function getWebservice() {
        if(!$this->strava_webservice) {
            $this->strava_webservice = new StravaWebservice();
        }
        return $this->strava_webservice;
    }

    public function getActivityWeeks() {
        $offset = 12;
        $weekOffset = 0;
        $currentWeek = date('W', strtotime(date('Y-m-d')));

        $activities = $this->getActivities();
        $activityWeeks = GroupedList::create($activities->sort('Week'))->groupedBy('Week');

        $svgWeeks = '';
        for($i=21; $i>=0; $i--) {
            $weekIndex = $currentWeek - $i;
            $dayOffset = 0;
            $svgWeek = '<g transform="translate('.$weekOffset.', 0)">';
            for($j=7; $j>=1; $j--) {
                $level = '0';
                $title = '';
                //TODO: if there are more activities for one day, then use the one with the highest level
                foreach($activityWeeks as $activityWeek) {
                    if($activityWeek->Week == $weekIndex) {
                        foreach($activityWeek->Children as $activity) {
                            if($activity->Day == $j) {
                                $level = $activity->Level;
                                $name = $activity->Name;
                                $distance = $activity->Distance.' km';
                                $type = $activity->Type;
                                $title = 'title="'.$name.' ['.$type.'] - Distance: '.$distance.'"';
                            }
                        }
                    }
                }
                $svgDay = '<rect class="stats-box level-'.$level.'" width="11" height="11" y="'.$dayOffset.'" '.$title.'/>';
                $dayOffset+=$offset;
                $svgWeek.=$svgDay;
            }
            $weekOffset+=$offset;
            $svgWeek.='</g>';
            $svgWeeks.= $svgWeek;
        }
        return $svgWeeks;
    }

    private function getActivities() {
        $retArray = new ArrayList();
        $bikeActivities = array();
        $runActivities = array();
        $leveledActivities = array();
        //TODO: handle no result
        $activities = $this->loadActivities();

        foreach($activities as $activity) {
            if($activity->type=='Ride') {
                array_push($bikeActivities, $activity);
            }
        }
        $bikeActivities = $this->setActivityLevel($bikeActivities);

        foreach($activities as $activity) {
            if($activity->type=='Run') {
                array_push($runActivities, $activity);
            }
        }
        $runActivities = $this->setActivityLevel($runActivities);

        foreach($activities as $activity) {
            foreach($bikeActivities as $bikeActivity) {
                if($bikeActivity->id == $activity->id) {
                    array_push($leveledActivities, $bikeActivity);
                }
            }
            foreach($runActivities as $runActivity) {
                if($runActivity->id == $activity->id) {
                    array_push($leveledActivities, $runActivity);
                }
            }
        };

        foreach($leveledActivities as $leveledActivity) {
            $tempActivity = new ViewableData($leveledActivity);
            $tempActivity->Name = $leveledActivity->name;
            $tempActivity->Type = $leveledActivity->type;
            $tempActivity->Distance = $leveledActivity->distance;
            $tempActivity->Level = $leveledActivity->level;
            $tempActivity->Week = $leveledActivity->week;
            $tempActivity->Day = $leveledActivity->day;
            $retArray->add($tempActivity);
        }
        return $retArray;
    }

    private function loadActivities() {
        $retArray = array();
        $activities = json_decode($this->getWebservice()->getActivities());

        foreach($activities as $activity) {
            $date = new DateTime($activity->start_date_local);
            $dateString = $date->format('Y-m-d');

            $tempActivity = new StdClass();
            $tempActivity->name = $activity->name;
            $tempActivity->type = $activity->type;
            $tempActivity->distance = round($activity->distance/1000, 2);
            $tempActivity->id = $activity->id;
            $tempActivity->start_date_local = $activity->start_date_local;
            $tempActivity->date = $dateString;
            $tempActivity->week = (int)date('W', strtotime($dateString));
            $tempActivity->day = (int)date('N', strtotime($dateString));
            array_push($retArray, $tempActivity);
        };
        return $retArray;
    }

    private function setActivityLevel($activities) {
        usort($activities, array($this, 'compare'));
        $minDistance = $activities[0]->distance;
        $maxDistance = $activities[count($activities)-1]->distance;
        foreach($activities as $activity) {
            $perc = ($activity->distance - $minDistance) / ($maxDistance - $minDistance);
            //set level
            if( $perc >= 0 && $perc < 0.25 ) {
                $activity->level = 1;
            }
            else if( $perc >= 0.25 && $perc < 0.5 ) {
                $activity->level = 2;
            }
            else if( $perc >= 0.5 && $perc < 0.75 ) {
                $activity->level = 3;
            }
            else if( $perc >= 0.75 && $perc <= 1 ) {
                $activity->level = 4;
            }
        }
        return $activities;
    }

    private function compare($a, $b) {
        if ($a->distance == $b->distance) {
            return 0;
        }
        return ($a->distance < $b->distance) ? -1 : 1;
    }
}