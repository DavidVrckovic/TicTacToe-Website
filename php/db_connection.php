<?php

function establish_db_connection(string $db_name = "local database"): mysqli|false
{
    static $db_connection = null;

    if ($db_connection === null) {
        $db_config = parse_ini_file("../Protected/config.ini", true);

        if (!$db_config) {
            $_SESSION["db_connection_error"] = "Failed to parse DB server data.";
            return false;
        }

        $db_connection = mysqli_connect(
            $db_config[$db_name]["db hostname"],
            $db_config[$db_name]["db username"],
            $db_config[$db_name]["db password"],
            $db_config[$db_name]["db database"]
        );

        if (mysqli_connect_errno()) {
            $_SESSION["db_connection_error"] = "Failed to connect to the DB server: " . mysqli_connect_error();
            return false;
        }
    }

    return $db_connection;
}



// Return the results of the provided query on the specified database
// Optional parameters and parameter types for prepared statements
//// The parameter array count must match the number of placeholders (and parameter types) in the query
// Parameter types:
//// "i" - integer
//// "d" - double
//// "s" - string
//// "b" - blob
// Example usage:
//// $results = db_get_query_results("local database", "SELECT * FROM users WHERE id = ?", [3], "i");
//// $results = db_get_query_results("local database", "SELECT * FROM users WHERE email = ?", ["test@example.com"], "s");

function db_get_query_results(mysqli $db_connection, string $db_query, array|false $parameters = false, string $parameter_types = ""): mysqli_result|bool
{
    if (!$db_connection) {
        $_SESSION["db_connection_error"] = "No DB connection established.";
        return false;
    }

    if (!$parameters) {
        $db_results = mysqli_query($db_connection, $db_query);
        if (!$db_results) {
            $_SESSION["db_connection_error"] = "Failed to execute DB query: " . mysqli_error($db_connection);
            return false;
        }
    } else {
        if (count($parameters) !== substr_count($db_query, "?")) {
            $_SESSION["db_connection_error"] = "Parameter count does not match the number of placeholders in the query.";
            return false;
        }
        $db_statement = mysqli_prepare($db_connection, $db_query);
        if (!$db_statement) {
            $_SESSION["db_connection_error"] = "Failed to prepare DB statement: " . mysqli_error($db_connection);
            return false;
        }
        $referenced_parameters = [];
        foreach ($parameters as $key => $value) {
            $referenced_parameters[$key] = &$parameters[$key];
        }
        if (!mysqli_stmt_bind_param($db_statement, $parameter_types, ...$referenced_parameters)) {
            $_SESSION["db_connection_error"] = "Failed to bind DB statement parameters: " . mysqli_stmt_error($db_statement);
            return false;
        }
        if (!mysqli_stmt_execute($db_statement)) {
            $_SESSION["db_connection_error"] = "Failed to execute DB statement: " . mysqli_stmt_error($db_statement);
            return false;
        }
        $db_results = mysqli_stmt_get_result($db_statement);
        if (!$db_results) {
            return true;
        }
    }

    return $db_results;
}
