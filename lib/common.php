<?php
/**
 * Gets the root path of the project
 *
 * @return string
 */
function getRootPath() {
    return dirname(__DIR__, 1);
}
/**
 * Gets the full path for the database file
 *
 * @return string
 */
function getDatabasePath() {
    return getRootPath() . '/data/data.sqlite';
}
/**
 * Gets the DSN for the SQLite connection
 *
 * @return string
 */
function getDsn() {
    return 'sqlite:' . getDatabasePath();
}
/**
 * Gets the PDO object for database access
 *
 * @return \PDO
 */
function getPDO() {
    return new PDO(getDsn());
}
/**
 * Escapes HTML so it is safe to output
 *
 * @param string $html
 * @return string
 */
function htmlEscape($html) {
    return htmlspecialchars($html, ENT_HTML5, 'UTF-8');
}