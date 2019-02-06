<?php

include('URL.php');

// Class that gets info from a DeviantArt group by parsing HTML
// Script should not take longer than 2 seconds, kill it if it takes longer than 4

set_time_limit(4); 

class DeviantArt
{
    private $username = '';
    private $http_code = 404;
    private $username_case = '';
    private $icon = '';
    private $raw_html = '';
    private $description = '';
    private $founded = '';
    private $members = 0;
    private $watchers = 0;
    private $pageviews = 0;

    public function __construct($un)
    {
        $this->username = $un;
        $curl = new URL('http://'.$un.'.deviantart.com/');
        $this->http_code = $curl->getResponseType();
        if ($this->http_code == 200) {
            $this->raw_html = $curl->getData();
            $this->getGoodStuff();
        }
        // If group 404s, do nothing
    }

    public function getInfoArray()
    {
        // Returns all relevant info (no HTML or groupid) in an associative array
        return array(
            'http_code' => $this->http_code,
            'username' => $this->username,
            'username_case' => $this->username_case,
            'icon' => $this->icon,
            'description' => $this->description,
            'founded' => $this->founded,
            'members' => $this->members,
            'pageviews' => $this->pageviews,
            'watchers' => $this->watchers
        );
    }

    private function getStringBetween($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    // Parses HTML to get relevant info and stores it, reading DA group source code will make most of this understandable
    public function getGoodStuff()
    {
    	$html_part_1 = $this->raw_html;

        $html_part_1 = strstr($html_part_1, '<div id="super-secret-stats"', FALSE);
        $html_part_1 = strstr($html_part_1, 'super-secret-buttons', TRUE);

        $html_part_1 = strstr($html_part_1, '<b>', FALSE);
        $this->members = (int) str_replace(',', '', $this->getStringBetween($html_part_1, '<b>', '</b>'));
        $html_part_1 = substr($html_part_1, 3);

        $html_part_1 = strstr($html_part_1,'<b>',FALSE);
        $this->watchers = (int) str_replace(',', '', $this->getStringBetween($html_part_1, '<b>', '</b>'));
        $html_part_1 = substr($html_part_1, 3);

        $html_part_1 = strstr($html_part_1, '<b>', FALSE);
        $this->pageviews = (int) str_replace(',', '', $this->getStringBetween($html_part_1, '<b>', '</b>'));
        $html_part_1 = substr($html_part_1, 3);

        $html_part_1 = strstr($html_part_1, 'Founded', FALSE);
        $this->founded = $this->convertDate($this->getStringBetween($html_part_1, '<br>', '<br></dd>'));

        $html_part_1 = strstr($html_part_1, 'super-secret-tagline', FALSE);
        $this->description = html_entity_decode(trim($this->getStringBetween($html_part_1, 'none">', '</div>')));

        $html_part_2 = $this->raw_html;

    	$html_part_2 = strstr($html_part_2, 'script type', TRUE);

        $this->username_case = explode(' ', ($this->getStringBetween($html_part_2, 'og:title" content="', '">')))[0];
        $fullIconURL = $this->getStringBetween($html_part_2, 'og:image" content="', '">');
        if ($fullIconURL == 'http://a.deviantart.net/avatars/default.gif') {
            // Placeholder for no group icon
            $this->icon = "nul";
        } else {
            // Save icon extension
            $dotPos = strrpos($fullIconURL, '.');
            $this->icon = substr($fullIconURL,$dotPos+1,3);
        }
    }

    // Obtain JSON rep of group admins/co-founders/contributors from group's admin page and return as array
    public function parseGroupAdmins() {
        $curl = new URL('http://'.$this->username.'.deviantart.com/aboutus/');
        $this->http_code = $curl->getResponseType();
        if ($this->http_code == 200) {
            $group_str = $this->getStringBetween($curl->getData(), '<span id="admins-list-popup-names">', '</span>');
            $admin_array = json_decode($group_str, true);
            return $admin_array;
        } else {
            // Return empty array on connection failure
            return array();
        }
    }

    // Converts date from form "Jul 4, 2016" that DA provides into a ISO 8601 form "2016-07-04"
    private function convertDate($input)
    {
        $new_date = DateTime::createFromFormat('M j, Y', $input, new DateTimeZone('UTC'));
        if ($new_date === FALSE) {
            return '0000-00-00';
        } else {
            return $new_date->format('Y-m-d');
        }
    }
}