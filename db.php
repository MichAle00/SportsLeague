<?
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "myDB";

    function createDB($server, $user, $pass)
    {
        $conn = new mysqli($server, $user, $pass);

        if ($conn->connect_error)
        {
            die("Connection failed: " . $conn->connect_error);
        }

        echo "Connection succesfull";


        $sql = "CREATE DATABASE myDB IF NOT EXISTS";

        if ($conn->query($sql) === TRUE)
        {
            echo "Database created succesfully";
        }
    }

    function createTables($server, $user, $pass, $db)
    {
        $conn = new mysqli($server, $user, $pass, $db);
        
        //table for the players
        $sql = "CREATE TABLE players(
            player_id INT PRIMARY KEY AUTO_INCREMENT,
            first_name VARCHAR(50),
            last_name VARCHAR(50),
            birth DATE,
            nationality VARCHAR(50),
            height_cm DECIMAL(5,2),
            weight_cm DECIMAL(5,2),
            position VARCHAR(30),
            jersey_number INT,
            current_team_id INT,
            is_active BOOLEAN DEFAULT TRUE,
            team_sport BOOLEAN,
            bio TEXT,
            FOREIGN KEY (current_team_id) REFERENCES teams(team_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table players";
        }

        //table for the teams
        $sql = "CREATE TABLE teams(
            team_id INT PRIMARY KEY AUTO_INCREMENT,
            team_name VARCHAR(100) NOT NULL,
            short_name VARCHAR(10),
            founded_year DATE,
            home_venue_id INT,
            league_id INT
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table teams";
        }

        //table for the competitions
        $sql = "CREATE TABLE competitions(
            competition_id INT PRIMARY KEY AUTO_INCREMENT,
            competition_name VARCHAR(100) NOT NULL,
            competition_type ENUM('league', 'cup', 'friendly', 'tournament') NOT NULL,
            season VARCHAR(20),
            start_date DATE,
            end_date DATE 
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table competitions";
        }

        //table for the venues
        $sql = "CREATE TABLE venues(
            venue_id INT PRIMARY KEY AUTO_INCREMENT;
            venue_name VARCHAR(100) NOT NULL,
            city VARCHAR(50),
            country VARCHAR(50),
            capacity INT,
            surface_type ENUM('grass', 'artificial', 'clay', 'hard', 'other')
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table venues";
        }

        //table for the individual matches in case of an individual sport
        $sql = "CREATE TABLE  matches_individual(
            match_id INT PRIMARY KEY AUTO_INCREMENT,
            player1_id INT NOT NULL,
            player2_id INT NOT NULL,
            sets_required INT DEFAULT 3,
            FOREIGN KEY (player1_id) REFERENCES players(player_id),
            FOREIGN KEY (player2_id) REFERENCES players(player_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table matches_individual";
        }

        //table for the sets in an individual match
        $sql = "CREATE TABLE sets(
            set_id INT PRIMARY KEY AUTO_INCREMENT,
            match_id INT NOT NULL,
            set_number INT NOT NULL,
            player1_games INT NOT NULL,
            player2_games INT NOT NULL,
            FOREIGN KEY (match_id) REFERENCES matches_individual(match_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table sets";
        }

        //table for the events that may ocurr in a match like a footbal match
        $sql = "CREATE TABLE match_events(
            event_id INT PRIMARY KEY AUTO_INCREMENT,
            match_id INT NOT NULL;
            event_type ENUM('goal', 'card', 'substitution', 'penalty', 'other') NOT NULL;
            player_id INT NOT NULL,
            team_id INT NOT NULL,
            minute INT NOT NULL,
            additional_info TEXT,
            FOREIGN KEY (match_id) REFERENCES matches(match_id),
            FOREIGN KEY (player_id) REFERENCES players(player_id),
            FOREIGN KEY (team_id) REFERENCES teams(team_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table match_events";
        }

        //table for the lineups of each match
        $sql = "CREATE TABLE match_lineups(
            lineup_id INT PRIMARY KEY AUTO_INCREMENT,
            match_id INT NOT NULL,
            team_id INT NOT NULL,
            player_id INT NOT NULL,
            position VARCHAR(30),
            is_starter BOOLEAN DEFAULT TRUE,
            shirt_number INT,
            FOREIGN KEY (match_id) REFERENCES matches(match_id),
            FOREIGN KEY (team_id) REFERENCES teams(teams_id),
            FOREIGN KEY (player_id) REFERENCES players(player_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table match_lineups";
        }

        //table for the careers of the players
        $sql = "CREATE TABLE player_career(
            career_id INT PRIMARY KEY AUTO_INCREMENT,
            player_id INT NOT NULL,
            team_id INT NOT NULL,
            start_date DATE NOT NULL,
            end_date DATE,
            appearances INT DEFAULT 0,
            goals INT DEFAULT 0,
            FOREIGN KEY (player_id) REFERENCES players(player_id),
            FOREIGN KEY (team_id) REFERENCES teams(team_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table player_careers";
        }

        //table for the player statistics 
        $sql = "CREATE TABLE player_statistics(
            stat_id INT PRIMARY KEY AUTO_INCREMENT,
            player_id INT NOT NULL,
            season VARCHAR(20) NOT NULL,
            competition_id INT,
            matches_played INT DEFAULT 0,
            goals INT DEFAULT 0,
            assists INT DEFAULT 0,
            yellow_cards INT DEFAULT 0,
            red_card INT DEFAULT 0,
            minutes_played INT DEFAULT 0,
            FOREIGN KEY (player_id) REFERENCES players(player_id),
            FOREIGN KEY (competition_id) REFERENCES competitions(competition_id)
        );";

        if ($conn->query($sql) === FALSE)
        {
            echo "Error creating table player_statistics";
        }
    }
?>