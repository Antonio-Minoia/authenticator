<?
if (isset($_COOKIE["PHPSESSID"])) {
    session_id($_COOKIE["PHPSESSID"]);
    $timeout = 86400; // un giorno

    //Set the maxlifetime of the session

    ini_set( "session.gc_maxlifetime", $timeout );

    //Set the cookie lifetime of the session

    ini_set( "session.cookie_lifetime", $timeout );
    session_start();
} else {
    header("Location: /");
}

if (!isset($_SESSION['user'])) {
    header('Location: ../login');
    exit;
}

function level_check($desired_level) {
    $level = $_SESSION['user']['tipo'];

    if(!($level>=$desired_level)){
        header('Location: ../dashboard');
        exit;
    }

}
