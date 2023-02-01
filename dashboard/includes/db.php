<?php
$connection;
function DB_CONNECT()
{
    global $connection;
    try {
        $connection = odbc_connect(
            "Driver={SQL Server};Server=185.56.168.171,59667;Database=Change;",
            'mexaldb',
            'mexaldbSystem7335'
        );
    } catch (\Throwable $th) {
        throw $th;
    }
}

function DB_SELECT_ONE(string $query)
{

    DB_CONNECT();

    global $connection;

    try {
        $result = odbc_exec($connection, $query);
        if (!$result) {
            return false;
        }
        $row = odbc_fetch_array($result);
        return $row;
    } catch (\Throwable $th) {
        throw $th;
        return false;
    }

    DB_DISCONNECT();
}



function DB_QUERY_SELECT(string $query)
{

    DB_CONNECT();

    global $connection;

    try {

        $result = odbc_exec($connection, $query);
        $data = array();

        while ($row = odbc_fetch_object($result)) {
            array_push($data, $row);
        }

        // return [$query, "->", $data];
        return $data;

        // return (empty($data) ? false : $data);
    } catch (\Throwable $th) {
        return false;
    }

    DB_DISCONNECT();
}

function DB_QUERY(string $query)
{

    DB_CONNECT();

    global $connection;

    try {

        $result = odbc_exec($connection, $query);

        if (mb_strpos($query, "SELECT")) {

            $data = array();

            while ($row = odbc_fetch_object($result)) {
                array_push($data, $row);
            }

            return (empty($data) ? false : $data);
        } else {
            return true;
        }
    } catch (\Throwable $th) {
        return false;
    }

    DB_DISCONNECT();
}

function DB_DISCONNECT()
{
    global $connection;
    odbc_close($connection);
}
