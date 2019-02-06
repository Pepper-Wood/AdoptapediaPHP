<?php
include_once('../HIDDEN/DB_CONNECTIONS.php');

class User {
    private $userid;
    private $username;
    private $deviantartid;
    private $type;
    private $styleid;

    public function __construct($resource_array) {
        $this->username = $resource_array['username'];
        $this->deviantartid = $resource_array['userid'];
    }

    public function addUserToDatabase() {
        $conn = OpenMainCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid, type) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."');";
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

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid, type, styleid) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."','user',10);";
            $conn->query($qry);
        }
        // Get user's table ID and status from siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        $row = mysqli_fetch_array($result);
        $this->userid = $row['userid'];
        $this->type = $row['type'];
        $this->styleid = $row['styleid'];

        CloseCon($conn);
    }

    public function addUserToJabberwockDatabase() {
        $conn = OpenJabberwockCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid, type) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."','user');";
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

    public function addUserToSelkicasDatabase() {
        $conn = OpenSelkicaCon();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if user already exists in siteusers
        $qry = "SELECT * FROM siteusers WHERE deviantartid='".$this->deviantartid."';";
        $result = $conn->query($qry);
        if (mysqli_num_rows($result) == 0) {
            // Add user if they do not exist
            $qry = "SELECT (max(userid) + 1) AS maxid FROM siteusers;";
            $maxid = mysqli_fetch_array($conn->query($qry))['maxid'];
            $qry = "INSERT INTO siteusers(userid, username, deviantartid, type) VALUES(".$maxid.",'".$this->username."','".$this->deviantartid."','user');";
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

    public function getStyleID() {
        return $this->styleid;
    }
}
