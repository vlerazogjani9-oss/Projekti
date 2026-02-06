<?php
/**
 * Dashboard entry point – redirects to admin dashboard with session handling.
 * Use: localhost/Projekti/dashboard.php
 */
session_start();

// Redirect to admin dashboard (which handles auth check)
header('Location: admin/dashboard.php');
exit;
