<?php

// session_start();

$expectedSessionId = isset($_SESSION["user_id"]) ? session_name() : null;

if ($expectedSessionId) {
    session_unset();
    session_destroy();
    error_log("User logged out successfully with session ID: " . $expectedSessionId);
} else {
    error_log("Logout attempt with invalid session ID.");
}

header("location: ../");
exit();
