<!-- Code referenced from Tutorial 7 -->

<html>
    <head>
        <title>NBA Repository 🏀</title>
    </head>

    <body>

    <h2> (Performs Create and Drop Tables) Create the Tables </h2>

    <form method="POST" action="nba-repository.php">
        <input type="hidden" id="createTableRequest" name="createTableRequest">
        <p><input type="submit" value="RESET" name="create"></p>
    </form>
        
    <hr>
        
    <h2> View the tables</h2>

    <form method="GET" action="nba-repository.php">
        <input type="hidden" id="viewTableRequest" name="viewTableRequest">
        Table Name: <input type="text" name="tableName"> <br /><br />
        <input type="submit" value="View" name="view">
    </form>
    
    <hr>
        
    <h2> (Insert Query) Insert into the Owners Table </h2>

    <form method="POST" action="nba-repository.php"> <!--refresh page when submitted-->
        <input type="hidden" id="insertIntoOwnerTableRequest" name="insertIntoOwnerTableRequest">
        OwnerID: <input type="text" name="ownerID"> <br /><br />
        OwnedSince: <input type="text" name="ownedSince"> <br /><br />
        OwnerName: <input type="text" name="ownerName"> <br /><br />
        Age: <input type="text" name="age"> <br /><br />
        Team: <input type="text" name="team"> <br /><br />

        <input type="submit" value="Insert" name="insertIntoOwnerTable"></p>
    </form>
        
    <hr />

        <h2> (Delete Query) Delete Tuple in Team_Owns Table</h2>
        <p>The values are case sensitive and if you enter in the wrong case, the delete statement will not do anything.</p>

        <form method="POST" action="nba-repository.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            Name of Team: <input type="text" name="element"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

    <hr>

    <h2> (Update Query) Update an attribute in the Stadium Table</h2>

    <form method="POST" action="nba-repository.php">
            <input type="hidden" id="updateTableRequest" name="updateTableRequest">
            
            <label for="attribute">Choose an attribute in the stadium table to update:</label>
            <select name="attribute" id="attribute">
                <option value="City">City</option>
                <option value="States">States</option>
                <option value="Sponsor">Sponsor</option>
            </select>
            <div style="margin-top: 1rem;">
                Old value: <input type="text" name="oldValue"> <br /><br />
                New value: <input type="text" name="newValue"> <br /><br />
            </div>
        
            <input type="submit" value="Update" name="updateSubmit"></p>
    </form>

    <hr>

    <h2> (Selection Query) Select from Players Table </h2>

    <form method="GET" action="nba-repository.php"> <!--refresh page when submitted-->
        <input type="hidden" id="selectFromPlayersRequest" name="selectFromPlayersRequest">
        Age is less than: <input type="text" name="age"> <br /><br />
        Position equals: <input type="text" name="position"> <br /><br />
        Team Name equals: <input type="text" name="teamName"> <br /><br />
        Points Per Game is greater than: <input type="text" name="ppg"> <br /><br />

        <input type="submit" value="Select" name="selectFromPlayers"></p>
    </form>

    <hr>

    <h2> (Projection Query) Project from Coaches Table </h2>

    <form method="GET" action="nba-repository.php"> <!--refresh page when submitted-->
        <input type="hidden" id="selectFromCoachesRequest" name="selectFromCoachesRequest">
        StaffID: <input type="text" name="coachStaffID"> <br /><br />
        Name: <input type="text" name="coachNames"> <br /><br />
        TeamName: <input type="text" name="coachTeamNames"> <br /><br />

        <input type="submit" value="Select" name="selectFromCoaches"></p>
    </form>  

     <hr>

    <h2> (Join Query) Join the Player_PlaysFor table and the Coach_coaches table</h2>

    <form method="GET" action="nba-repository.php">
            <input type="hidden" id="joinTableRequest" name="joinTableRequest">
            <label for="clause">Choose an attribute clause to join:</label>
            <input type="text" name="clause"> <br /><br />
            <input type="submit" value="Join" name="joinSubmit"></p>
    </form>

    <hr>

    <h2> (GROUP BY Query) View the number of stadiums in each state </h2>

    <form method="GET" action="nba-repository.php">
        <input type="hidden" id="groupByTableRequest" name="groupByTableRequest">
        <p><input type="submit" value="Group Stadiums" name="groupByTable"></p>
    </form>

    <hr>

    <h2> (HAVING Query) View the minimum number of stadiums using the HAVING SQL Query </h2>

    <form method="GET" action="nba-repository.php">
        <input type="hidden" id="havingTableRequest" name="havingTableRequest">
        Minimum number of stadiums: <input type="text" name="element"> <br /><br />
        <p><input type="submit" value="Display Minimum Number of Stadiums" name="havingTable"></p>
    </form>

    <hr>

    <h2> (NESTED AGGREGATION Query) Find Teams with multiple stadiums using Aggregate Function </h2>

    <form method="GET" action="nba-repository.php">
        <input type="hidden" id="aggregateTableRequest" name="aggregateTableRequest">
        Please Input Number Of Stadiums: <input type="text" name="element"> <br /><br />
        <p><input type="submit" value="Submit" name="aggregateTable"></p>
    </form>

    <hr>

    <h2> (DIVISION Query) View the team that won in all stadiums  </h2>

    <form method="GET" action="nba-repository.php">
        <input type="hidden" id="divisionRequest" name="divisionRequest">
        <p><input type="submit" value="Division Query" name="division"></p>
    </form>

    <?php
    
    //  **** PHP CODE *****

    // $db_connection = NULL;
    $success = True; //keep track of errors so it redirects the page only if there are no errors
    $db_conn = NULL; // edit the login credentials in connectToDB()
    $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

    # establish connection with db
    function connectToDB() {
        global $db_conn;

        // Your username is ora_(CWL_ID) and the password is a(student number). For example,
        // ora_platypus is the username and a12345678 is the password.
        $db_conn = OCILogon("ora_yookyeom", "a90327602", "dbhost.students.cs.ubc.ca:1522/stu");

        if ($db_conn) {
            debugAlertMessage("Database is Connected");
            echo "Database is Connected";
            return true;
        } else {
            debugAlertMessage("Cannot connect to Database");
            $e = OCI_Error(); // For OCILogon errors pass no handle
            echo htmlentities($e['message']);
            return false;
        }
    }

    # disconnect from db
    function disconnectFromDB() {
        global $db_conn;

        debugAlertMessage("Disconnect from Database");
        OCILogoff($db_conn);
    }

    # Alert Message
    function debugAlertMessage($message) {
        global $show_debug_alert_messages;

        if ($show_debug_alert_messages) {
            echo "<script type='text/javascript'>alert('" . $message . "');</script>";
        }
    }

    # route POST requests
    function handlePOSTRequest() {

        if (connectToDB()) {
            // ADD METHODS THAT UPDATE OR DELETE IN THE DATABASE
            if (array_key_exists('createTableRequest', $_POST)) {
                createTableRequest();
            } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                handleDeleteRequest();
            } else if (array_key_exists('updateTableRequest', $_POST)) {
                updateTableRequest();
            } else if (array_key_exists('insertIntoOwnerTableRequest', $_POST)) {
                insertIntoOwnerTableRequest();
            } 

            disconnectFromDB();
        }
    }

    # route GET requests
    function handleGETRequest() {
        $is_connected = connectToDB();

        if ($is_connected) {
            // ADD METHODS THAT READ FROM THE DATABASE

            if (array_key_exists('viewTableRequest', $_GET)) {
                viewTableRequest();
            } else if (array_key_exists('selectFromPlayersRequest', $_GET)) {
                selectFromPlayersRequest();
            }else if (array_key_exists('groupByTableRequest', $_GET)) {
                groupByTableRequest();
            }else if (array_key_exists('havingTableRequest', $_GET)) {
                havingTableRequest();
            } else if (array_key_exists('joinTableRequest', $_GET)) {
                joinTableRequest();
            } else if (array_key_exists('selectFromCoachesRequest', $_GET)) {
                selectFromCoachesRequest();
            }else if (array_key_exists('aggregateTableRequest', $_GET)) {
                aggregateTableRequest();
            } else if (array_key_exists('divisionRequest', $_GET)) {
                divisionRequest();
            }

            disconnectFromDB();
        }
    }

    # check tables
    function viewTableRequest() {
        global $db_conn;

        $table_name = $_GET['tableName'];

        $result = executePlainSQL("SELECT * FROM {$table_name}");
        
        printResult($result);
    }

    function printResult($result) { //prints results from a select statement
        echo "<br>Retrieved data from table<br>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            // echo "<tr><td>" . $row["OwnerID"] . "</td><td>" . $row["OwnedSince"] . "</td></tr>"; //or just use "echo $row[0]" 
            echo $row[0] . " ";
            echo $row[1] . " ";
            echo $row[2] . " ";
            echo $row[3] . " ";
            echo $row[4] . " ";
            echo $row[5] . " ";
            echo $row[6] . " ";
            echo "<br>";
        }
    }

    # create the tables
    function createTableRequest() {
        global $db_conn;

        # drop the tables
        executePlainSQL("DROP TABLE Plays");
        executePlainSQL("DROP TABLE Trains");
        executePlainSQL("DROP TABLE Player_PlaysFor");
        executePlainSQL("DROP TABLE Participates_in");
        executePlainSQL("DROP TABLE Coach_coaches");
        executePlainSQL("DROP TABLE Mascot_represents");
        executePlainSQL("DROP TABLE Trainer_trains");
        executePlainSQL("DROP TABLE Game_PlayedIn");
        executePlainSQL("DROP TABLE Team_Owns");
        executePlainSQL("DROP TABLE Stadium");
        executePlainSQL("DROP TABLE Owners");
        executePlainSQL("DROP TABLE Staff");
        
        
        # create stadium table
        executePlainSQL("CREATE TABLE Stadium (
            StadiumName VARCHAR(50) Primary Key,
            City VARCHAR(30),
            States VARCHAR(30),
            Sponsor VARCHAR(20)
           )");
        # create owner table
        executePlainSQL("CREATE TABLE Owners (
            OwnerID INTEGER Primary Key,
            OwnedSince VARCHAR(10),
            OwnerName VARCHAR(20),
            Age INTEGER,
            Team VARCHAR(50)
           )");
        # create staff table
        executePlainSQL("CREATE TABLE Staff (StaffID INTEGER, Primary Key (StaffID))");
        # create trainer table
        executePlainSQL("CREATE TABLE Trainer_trains(StaffID INTEGER Primary Key, Names VARCHAR(20), PlayerID INTEGER,Foreign Key (StaffID) REFERENCES Staff(StaffID) ON DELETE CASCADE)");
        # create game table
        executePlainSQL("CREATE TABLE Game_PlayedIn (GameID INTEGER, WinningTeam VARCHAR(100) NOT NULL, HomeTeam VARCHAR(100) NOT NULL, GameDate VARCHAR(50) NOT NULL, AwayTeam VARCHAR(100) NOT NULL, FinalScore VARCHAR(10) NOT NULL, StadiumName VARCHAR(50) NOT NULL, Primary Key (GameID), Foreign Key (StadiumName) REFERENCES Stadium(StadiumName))");
        # create team table
        executePlainSQL("CREATE TABLE Team_Owns (Names VARCHAR(100), States VARCHAR(30), City VARCHAR(30), Conference VARCHAR(20), StadiumName VARCHAR(50), OwnerID INTEGER, UNIQUE (OwnerID), Primary Key (Names), Foreign Key (StadiumName) REFERENCES Stadium(StadiumName), Foreign Key (OwnerID) REFERENCES Owners(OwnerID) ON DELETE CASCADE)");
        # create player table
        executePlainSQL("CREATE TABLE Player_PlaysFor (PlayerID INTEGER, Names VARCHAR(50) NOT NULL, Age INTEGER NOT NULL, Position VARCHAR(2) NOT NULL, TeamName VARCHAR(50) NOT NULL, PointsPerGame FLOAT NOT NULL, Primary Key (PlayerID), Foreign Key (TeamName) REFERENCES Team_Owns(Names) ON DELETE CASCADE)");
        # create participates in table
        executePlainSQL("CREATE TABLE Participates_in(Names VARCHAR(100), GameID INTEGER, Foreign Key (Names) REFERENCES Team_Owns(Names) ON DELETE CASCADE, Foreign Key (GameID) REFERENCES Game_PlayedIn (GameID) ON DELETE CASCADE)");
        # create coach table
        executePlainSQL("CREATE TABLE Coach_coaches (StaffID INTEGER PRIMARY KEY, Names VARCHAR(20) NOT NULL, TeamName VARCHAR(100) NOT NULL, Foreign Key (StaffID) REFERENCES Staff (StaffID) ON DELETE CASCADE, Foreign Key (TeamName) REFERENCES Team_Owns (Names) ON DELETE CASCADE)");
        # create mascot table
        executePlainSQL("CREATE TABLE Mascot_represents (Names VARCHAR(50), TeamName VARCHAR(50) NOT NULL, Primary Key (Names, TeamName), Foreign Key (TeamName) REFERENCES Team_Owns(Names) ON DELETE CASCADE)");
        # create train table
        executePlainSQL("CREATE TABLE Trains(PlayerID INTEGER, StaffID INTEGER, Primary Key (PlayerID, StaffID), Foreign Key (PlayerID) REFERENCES Player_PlaysFor(PlayerID) ON DELETE CASCADE, Foreign Key (StaffID) REFERENCES Staff(StaffID) ON DELETE CASCADE)");
        # create plays table
        executePlainSQL("CREATE TABLE Plays(PlayerID INTEGER, GameID INTEGER, Foreign Key (PlayerID) REFERENCES Player_PlaysFor(PlayerID) ON DELETE CASCADE, Foreign Key (GameID) REFERENCES Game_PlayedIn (GameID) ON DELETE CASCADE)");

        # insert into stadium tables
        executePlainSQL("INSERT INTO Stadium VALUES('Staples Center', 'Los Angeles', 'California', 'Staples')");
        executePlainSQL("INSERT INTO Stadium VALUES('Chase Center', 'San Francisco', 'California', 'JP Morgan Chase')");
        executePlainSQL("INSERT INTO Stadium VALUES('American Airlines Center', 'Dallas', 'Texas', 'American Airlines')");
        executePlainSQL("INSERT INTO Stadium VALUES('Barclays Center', 'Brooklyn', 'New York', 'Barclays')");
        executePlainSQL("INSERT INTO Stadium VALUES('State Farm Arena', 'Atlanta', 'Georgia', 'State Farm')");
        executePlainSQL("INSERT INTO Stadium VALUES('Hearst Greek Theatre', 'San Francisco', 'California', 'Berkeley')");
        executePlainSQL("INSERT INTO Stadium VALUES('Stanford Stadium', 'Stanford', 'California', 'Stanford')");
        executePlainSQL("INSERT INTO Stadium VALUES('Mercedes-Benz Stadium', 'Atlanta', 'Georgia', 'Mercedes-Benz')");
        executePlainSQL("INSERT INTO Stadium VALUES('Road Atlanta', 'Atlanta', 'Georgia', 'State Farm')");
        executePlainSQL("INSERT INTO Stadium VALUES('Yankee Stadium', 'Brooklyn', 'New York', 'Barclays')");

        # insert into owner table
        executePlainSQL("INSERT INTO Owners VALUES(1, '2017', 'Tilman Fertitta', 63, 'Houston Rockets')");
        executePlainSQL("INSERT INTO Owners VALUES(2, '2013', 'Jeanie Buss', 60, 'Los Angeles Lakers')");
        executePlainSQL("INSERT INTO Owners VALUES(3, '2010', 'Peter Guber', 79, 'Golden State Warriors')");
        executePlainSQL("INSERT INTO Owners VALUES(4, '2000', 'Mark Cuban', 63, 'Dallas Mavericks')");
        executePlainSQL("INSERT INTO Owners VALUES(5, '2019', 'Joseph Tsai', 57, 'Brooklyn Nets')");

        # insert into staff
        executePlainSQL("INSERT INTO Staff VALUES(1)");
        executePlainSQL("INSERT INTO Staff VALUES(2)");
        executePlainSQL("INSERT INTO Staff VALUES(3)");
        executePlainSQL("INSERT INTO Staff VALUES(4)");
        executePlainSQL("INSERT INTO Staff VALUES(5)");

        # insert into trainer
        executePlainSQL("INSERT INTO Trainer_trains VALUES(1, 'Drew Hanlen', 1)");
        executePlainSQL("INSERT INTO Trainer_trains VALUES(2, 'Devin Williams', 2)");
        executePlainSQL("INSERT INTO Trainer_trains VALUES(3, 'Chris Johnson', 3)");
        executePlainSQL("INSERT INTO Trainer_trains VALUES(4, 'Jordan Lawley', 4)");
        executePlainSQL("INSERT INTO Trainer_trains VALUES(5, 'DJ Sackmann', 5)");

        # insert into game
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(2, 'Brooklyn Nets', 'Atlanta Hawks', '2021-10-13', 'Atlanta Hawks', '108-98', 'Barclays Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(4, 'Golden State Warriors', 'Brooklyn Nets', '2021-10-19', 'Brooklyn Nets', '114-112', 'Barclays Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(5, 'Atlanta Hawks', 'Los Angeles Lakers', '2021-10-04', 'Atlanta Hawks', '115-127', 'State Farm Arena')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(1, 'Los Angeles Lakers', 'Golden State Warriors', '2021-10-17', 'Golden State Warriors', '113-115', 'Chase Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(3, 'Los Angeles Lakers', 'Dallas Mavericks', '2021-9-09', 'Los Angeles Lakers', '100-98', 'Staples Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(6, 'Los Angeles Lakers', 'Toronto Raptors', '2021-8-09', 'Los Angeles Lakers', '98-88', 'Hearst Greek Theatre')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(7, 'Los Angeles Lakers', 'Boston Celtics', '2021-7-09', 'Los Angeles Lakers', '95-91', 'Stanford Stadium')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(8, 'Los Angeles Lakers', 'Atlanta Hawks', '2021-6-09', 'Los Angeles Lakers', '89-67', 'Mercedes-Benz Stadium')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(9, 'Los Angeles Lakers', 'Brooklyn Nets', '2021-5-09', 'Los Angeles Lakers', '111-90', 'Road Atlanta')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(10, 'Los Angeles Lakers', 'Clippers', '2021-4-09', 'Los Angeles Lakers', '121-98', 'Yankee Stadium')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(11, 'Los Angeles Lakers', 'Orlando Magics', '2021-3-09', 'Los Angeles Lakers', '98-55', 'American Airlines Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(12, 'Los Angeles Lakers', 'Milwaukee Bucks', '2021-2-09', 'Los Angeles Lakers', '101-60', 'Barclays Center')");
        executePlainSQL("INSERT INTO Game_PlayedIn VALUES(13, 'Los Angeles Lakers', 'Atlanta Hawks', '2021-1-19', 'Los Angeles Lakers', '131-123', 'State Farm Arena')");

        # insert into team
        executePlainSQL("INSERT INTO Team_Owns VALUES('Los Angeles Lakers', 'California', 'Los Angeles', 'Western', 'Staples Center', '1')");
        executePlainSQL("INSERT INTO Team_Owns VALUES('Golden State Warriors', 'California', 'San Francisco', 'Western', 'Chase Center', '2')");
        executePlainSQL("INSERT INTO Team_Owns VALUES('Dallas Mavericks', 'Texas', 'Dallas', 'Western', 'American Airlines Center', '3')");
        executePlainSQL("INSERT INTO Team_Owns VALUES('Brooklyn Nets', 'New York', 'Brooklyn', 'Eastern', 'Barclays Center', '4')");
        executePlainSQL("INSERT INTO Team_Owns VALUES('Atlanta Hawks', 'Georgia', 'Atlanta', 'Eastern', 'State Farm Arena', '5')");

        # insert into player
        executePlainSQL("INSERT INTO Player_PlaysFor VALUES(1, 'Lebron James', 36, 'SF', 'Los Angeles Lakers', 28.7)");
        executePlainSQL("INSERT INTO Player_PlaysFor VALUES(2, 'Stephen Curry', 33, 'PG', 'Golden State Warriors', 27.5)");
        executePlainSQL("INSERT INTO Player_PlaysFor VALUES(3, 'Luka Doncic', 22, 'PG', 'Dallas Mavericks', 29.4)");
        executePlainSQL("INSERT INTO Player_PlaysFor VALUES(4, 'Kevin Durant', 33, 'SF', 'Brooklyn Nets', 28.3)");
        executePlainSQL("INSERT INTO Player_PlaysFor VALUES(5, 'Trae Young', 23, 'PG', 'Atlanta Hawks', 26.3)");

        # insert into participates
        executePlainSQL("INSERT INTO Participates_in VALUES('Los Angeles Lakers', 5)");
        executePlainSQL("INSERT INTO Participates_in VALUES('Golden State Warriors', 1)");
        executePlainSQL("INSERT INTO Participates_in VALUES('Dallas Mavericks', 3)");
        executePlainSQL("INSERT INTO Participates_in VALUES('Brooklyn Nets', 4)");
        executePlainSQL("INSERT INTO Participates_in VALUES('Atlanta Hawks', 2)");

        # insert into coach
        executePlainSQL("INSERT INTO Coach_coaches VALUES(1, 'Frank Vogel', 'Los Angeles Lakers')");
        executePlainSQL("INSERT INTO Coach_coaches VALUES(2, 'Steve Kerr', 'Golden State Warriors')");
        executePlainSQL("INSERT INTO Coach_coaches VALUES(3, 'Jason Kidd', 'Dallas Mavericks')");
        executePlainSQL("INSERT INTO Coach_coaches VALUES(4, 'Steve Nash', 'Brooklyn Nets')");
        executePlainSQL("INSERT INTO Coach_coaches VALUES(5, 'Nate Mcmillan', 'Atlanta Hawks')");

        # insert into mascot
        executePlainSQL("INSERT INTO Mascot_represents VALUES('Champ', 'Dallas Mavericks')");
        executePlainSQL("INSERT INTO Mascot_represents VALUES('Harry the Hawk', 'Atlanta Hawks')");
        executePlainSQL("INSERT INTO Mascot_represents VALUES('Duncan the Dragon', 'Brooklyn Nets')");
        executePlainSQL("INSERT INTO Mascot_represents VALUES('Wigan Warriors Mighty Max', 'Golden State Warriors')");
        executePlainSQL("INSERT INTO Mascot_represents VALUES('Clutch', 'Los Angeles Lakers')");

        # insert into trains
        executePlainSQL("INSERT INTO Trains VALUES(1,1)");
        executePlainSQL("INSERT INTO Trains VALUES(2,2)");
        executePlainSQL("INSERT INTO Trains VALUES(3,3)");
        executePlainSQL("INSERT INTO Trains VALUES(4,4)");
        executePlainSQL("INSERT INTO Trains VALUES(5,5)");

        # insert into plays
        executePlainSQL("INSERT INTO Plays VALUES(1,5)");
        executePlainSQL("INSERT INTO Plays VALUES(2,1)");
        executePlainSQL("INSERT INTO Plays VALUES(3,3)");
        executePlainSQL("INSERT INTO Plays VALUES(4,4)");
        executePlainSQL("INSERT INTO Plays VALUES(5,5)");

    }
    
    # check data from HTML form for POST
    if (isset($_POST['create']) || isset($_POST['deleteSubmit']) || isset($_POST['updateSubmit']) || isset($_POST['insertIntoOwnerTable'])) {
        handlePOSTRequest();
    } 
    # check data from HTML form for GET
    else if (isset($_GET['view']) || isset($_GET['selectFromPlayers']) || isset($_GET['groupByTable']) || isset($_GET['havingTable']) || isset($_GET['joinSubmit']) || isset($_GET['selectFromCoaches']) || isset($_GET['aggregateTable']) || isset($_GET['division'])) {
        handleGETRequest();
    }

    # method to execute sql statements
    function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
        //echo "<br>running ".$cmdstr."<br>";
        global $db_conn, $success;

        $statement = OCIParse($db_conn, $cmdstr);
        //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

        if (!$statement) {
            echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
            echo htmlentities($e['message']);
            $success = False;
        }

        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
            echo htmlentities($e['message']);
            $success = False;
        }
        OCICommit($db_conn);

        return $statement;
    }

    # Update an attribute in the stadium table
    function updateTableRequest() {
        global $db_conn;

        $attribute = $_POST['attribute'];
        $old_value = $_POST['oldValue'];
        $new_value = $_POST['newValue'];

        // you need the wrap the old name and new name values with single quotations
        executePlainSQL("UPDATE Stadium SET $attribute='" . $new_value . "' WHERE $attribute='" . $old_value . "'");
        OCICommit($db_conn);
    }
    
    # method to execute sql delete statements
    function handleDeleteRequest() {
        global $db_conn;

        $element = $_POST['element'];

        // you need the wrap the old name and new name values with single quotations
        // executePlainSQL("DELETE FROM Team_Owns WHERE Names='Los Angeles Lakers'");
        executePlainSQL("DELETE FROM Team_Owns WHERE Names = '" . $element . "'");

    }

    # select from players table query
    function selectFromPlayersRequest() {
        global $db_conn;

        $age = $_GET['age'];
        $position = $_GET['position'];
        $team_name = $_GET['teamName'];
        $ppg = $_GET['ppg'];

        $sql = "SELECT PlayerID, Names from Player_PlaysFor WHERE Age < {$age} AND Position = '{$position}' AND TeamName = '{$team_name}' AND PointsPerGame > {$ppg}";

        $result = executePlainSQL($sql);
        
        # print the result
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo $row[0] . " ";
            echo $row[1] . " ";
            echo $row[2] . " ";
            echo $row[3] . " ";
            echo $row[4] . " ";
            echo $row[5] . " ";
            echo $row[6] . " ";
        }
    }

    # insert tuple into the owners table
    function insertIntoOwnerTableRequest() {
        global $db_conn;

        $owner_id = $_POST['ownerID'];
        $owned_since = $_POST['ownedSince'];
        $owner_name = $_POST['ownerName'];
        $age = $_POST['age'];
        $team = $_POST['team'];

        executePlainSQL("INSERT INTO Owners (OwnerId, OwnedSince, OwnerName, Age, Team) VALUES('$owner_id', '$owned_since', '$owner_name', '$age', '$team')");
    }

    # method to execute sql group by statements
    function groupByTableRequest() {
        global $db_conn;

        $result = executePlainSQL("SELECT count(StadiumName), States from Stadium GROUP BY States");
        printResult($result);

    }

    # method to execute sql Having statements
    function havingTableRequest() {
        global $db_conn;
        $element = $_GET['element'];
        $result = executePlainSQL("SELECT count(StadiumName), States from Stadium GROUP BY States HAVING count(StadiumName) >= '{$element}'");
        printResult($result);

    }

     # Join the Player_PlaysFor and Coach_coaches tables
     function joinTableRequest() {
        global $db_conn;
         
        $clause = $_GET['clause'];
        $results = executePlainSQL("SELECT Player_PlaysFor.Names, Player_PlaysFor.PointsPerGame, Coach_coaches.Names, Player_PlaysFor.TeamName FROM Player_PlaysFor INNER JOIN Coach_coaches ON Player_PlaysFor.$clause=Coach_coaches.$clause");
        
        printResult($results);
    }

    # select from coaches table
    function selectFromCoachesRequest() {
        global $db_conn;

        $coach_staff_id = $_GET['coachStaffID'];
        $coach_names = $_GET['coachNames'];
        $coach_team_names = $_GET['coachTeamNames'];

        echo "<br>";

        if (!empty($coach_staff_id)) {
            $first_result = executePlainSQL("SELECT StaffID FROM Coach_coaches");
            echo "<b>StaffID</b> <br>";
            while ($row = OCI_Fetch_Array($first_result, OCI_BOTH)) {
                echo $row[0] . " ";
                echo "<br>";
            }
        }

        if (!empty($coach_names)) {
            $second_result = executePlainSQL("SELECT Names FROM Coach_coaches");
            echo "<b>Names</b> <br>";
            while ($row = OCI_Fetch_Array($second_result, OCI_BOTH)) {
                echo $row[0] . " ";
                echo "<br>";
            }
        }

        if (!empty($coach_team_names)) {
            $third_result = executePlainSQL("SELECT TeamName FROM Coach_coaches");
            echo "<b>TeamName</b> <br>";
            while ($row = OCI_Fetch_Array($third_result, OCI_BOTH)) {
                echo $row[0] . " ";
                echo "<br>";
            }
        }
    }

    # method to execute sql aggregate GROUP BY statements
    function aggregateTableRequest() {
        global $db_conn;
        $element = $_GET['element'];
        $result = executePlainSQL("SELECT Names from Team_Owns WHERE States = ANY(SELECT States from Stadium GROUP BY States HAVING count(StadiumName) >= '{$element}')");        
        printResult($result);
    }

    # division query
    function divisionRequest() {
        $result = executePlainSQL("SELECT WinningTeam FROM Game_PlayedIn
        WHERE NOT EXISTS (
            (SELECT Stadium.StadiumName FROM Stadium WHERE NOT EXISTS(
                (SELECT Game_PlayedIn.WinningTeam FROM Game_PlayedIn,Stadium WHERE Game_PlayedIn.StadiumName = Stadium.StadiumName)
                )
            )
        )");
    }
    
    ?>

    </body>
</html>