<?php
class Database {
    private static ?PDO $instance = null;

    public static function connect(): PDO {
        if (self::$instance === null) {
            $dsn = 'mysql:host=' . DB_HOST
                 . ';port='     . DB_PORT
                 . ';dbname='   . DB_NAME
                 . ';charset='  . DB_CHARSET;

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                die('<div style="font-family:sans-serif;padding:40px;color:#c00;">
                        <strong>Database connection failed.</strong><br>
                        ' . (APP_ENV === 'development' ? $e->getMessage() : 'Please try again later.') . '
                     </div>');
            }
        }
        return self::$instance;
    }
}