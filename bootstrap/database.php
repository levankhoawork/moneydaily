<?php
use Illuminate\Database\Capsule\Manager;

$capsule = new Manager;

$config = config('connections');
// MySQL Connection
if (config('default') == 'mysql') {
    $capsule->addConnection($config['mysql']);
    // Raw PDO Connection
    $pdo = new \PDO($config['mysql']['driver'].':dbname='.$config['mysql']['database'].';host='.$config['mysql']['host'].';charset='.$config['mysql']['charset'].'', $config['mysql']['username'], $config['mysql']['password']);
}
// SQLite Connection
elseif (config('default') == 'sqlite') {
    $capsule->addConnection($config['sqlite']);
    // Raw PDO Connection
    $pdo = new PDO($config['sqlite']['driver'].":".$config['sqlite']['driver']);
}
// PostgreSQL Connection
elseif (config('default') == 'pgsql') {
    $capsule->addConnection($config['pgsql']);
    // Raw PDO Connection
    $dsn = sprintf(
        'pgsql:host=%s;port=%s;dbname=%s;sslmode=%s;options=--client_encoding=UTF8',
        $config['pgsql']['host'],
        $config['pgsql']['port'],
        $config['pgsql']['database'],
        $config['pgsql']['sslmode'] ?? 'require'
    );

    $pdo = new \PDO($dsn, $config['pgsql']['username'], $config['pgsql']['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

}
// SQL Server Connection
elseif (config('default') == 'sqlsrv') {
    $capsule->addConnection($config['sqlsrv']);
    // Raw PDO Connection
    $pdo = new PDO($config['sqlsrv']['driver']."sqlsrv:server=".$config['sqlsrv']['host'].";".$config['sqlsrv']['database'], $config['sqlsrv']['username'], $config['sqlsrv']['password']);
}
// MySQL Connection as default
else{
    $capsule->addConnection($config['mysql']);
    // Raw PDO Connection
    $pdo = new \PDO($config['mysql']['driver'].':dbname='.$config['mysql']['database'].';host='.$config['mysql']['host'].';charset='.$config['mysql']['charset'].'', $config['mysql']['username'], $config['mysql']['password']);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();
