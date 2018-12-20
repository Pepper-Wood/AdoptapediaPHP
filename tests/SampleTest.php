<?php
require_once "/home/adoptape/public_html/util/DeviantArt.php";
require_once "/home/adoptape/public_html/util/User.php";
require_once "/home/adoptape/public_html/util/URL.php";
use PHPUnit\Framework\TestCase;

include_once('../HIDDEN/DB_CONNECTIONS.php');

class SampleTest extends TestCase
{
    public function testDB()
    {
        $conn = OpenMainCon();
        $this->assertEquals($conn->error, "");
        $this->assertEquals($conn->close(), TRUE);
    }

    public function testGroup()
    {
        $da = new DeviantArt("Adoptapedia");
        $group_array = $da->getInfoArray();
        $this->assertTrue($group_array['members'] > 1500);
        $this->assertTrue($group_array['pageviews'] > 25000);
        $this->assertTrue($group_array['watchers'] > 1500);
        $this->assertEquals($group_array['founded'], "2013-02-25");
        $this->assertFalse($group_array['username_case'] != "Adoptapedia");
    }

    public function testGroup2()
    {
        $da = new DeviantArt("candycorn-kingdom");
        $group_array = $da->getInfoArray();
        $this->assertTrue($group_array['members'] < 1000);
        $this->assertTrue($group_array['pageviews'] < 10000);
        $this->assertTrue($group_array['watchers'] < 1000);
        $this->assertEquals($group_array['founded'], "2016-11-01");
        $this->assertFalse($group_array['username_case'] != "Candycorn-Kingdom");
    }

    public function testURL() {
        $url = new URL("http://httpstat.us/200");
        $this->assertEquals($url->getResponseType(), "200");
        $url = new URL("http://httpstat.us/301");
        $this->assertEquals($url->getResponseType(), "301");
        $url = new URL("http://httpstat.us/403");
        $this->assertEquals($url->getResponseType(), "403");
        $url = new URL("http://httpstat.us/404");
        $this->assertEquals($url->getResponseType(), "404");
        $url = new URL("http://httpstat.us/504");
        $this->assertEquals($url->getResponseType(), "504");
    }

    public function testUsers() {
        $resource_array = array('username' => 'Adoptapedia-Lucy', 'userid' => 'FDD41940-A620-3CA4-5DBD-BEC1EDE95924');
        $user = new User($resource_array);
        $this->assertEquals($user->getUsername(), 'Adoptapedia-Lucy');
        $conn = OpenMainCon();
        $qry = "SELECT * FROM siteusers";
        $result_before = $conn->query($qry);
        $rows_before = mysqli_num_rows($result_before);
        for ($i = 0; $i < 100; $i++) {
            $user->addUserToDatabase();
        }
        $result_after = $conn->query($qry);
        $rows_after = mysqli_num_rows($result_after);
        $this->assertEquals($rows_before, $rows_after);
        $this->assertEquals($user->getID(), 2);
        $this->assertEquals($user->getType(), 'admin');
    }
}
