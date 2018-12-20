<?php
include_once('../HIDDEN/DB_CONNECTIONS.php');

class User {
    private $userid;
    private $username;
    private $deviantartid;
    private $type;

    public function __construct($resource_array)
    {
        $this->username = $resource_array['username'];
        $this->deviantartid = $resource_array['userid'];
    }

    public function addUserToDatabase() {
        $conn = OpenMainCon();

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."');";
            $conn->query($qry);
        }
        // Get user's table ID and status from siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        $row = mysqli_fetch_array($result);
        $this->userid = $row['userid'];
        $this->type = $row['type'];

        CloseCon($conn);
    }

    public function addUserToOofooDatabase() {
        $conn = OpenOofooCon();

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."');";
            $conn->query($qry);
        }
        // Get user's table ID and status from siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        $row = mysqli_fetch_array($result);
        $this->userid = $row['userid'];
        $this->type = $row['type'];

        CloseCon($conn);
    }

    public function saveToSession() {
        $_SESSION['user'] = $this;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getID() {
        return $this->userid;
    }

    public function getType() {
        return $this->type;
    }
}
