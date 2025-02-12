<?php
include "password_hash.php";
// PRODUCTION
//$host = '127.0.0.1';
//$db   = 'proseto17';
//$user = 'proseto17';
//$pass = 'bOGust56';
//$charset = 'utf8';
// DEVELOPMENT
//$host = '127.0.0.1';
//$db   = 'proseto17';
//$user = 'root';
//$pass = '';
//$charset = 'utf8';
function connect()
{
    $host = '127.0.0.1';
    $db = 'proseto17';
    $user = 'proseto17';
    $pass = 'bOGust56';
    $charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    );
    try {
        return new PDO($dsn, $user, $pass, $opt);
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}
function findUserByEmail($email)
{
    $connection = connect();
    $sql = "SELECT * FROM users where email=:email";
    $statement = $connection->prepare($sql);
    $statement->execute(array($email));
    return $statement;
}
function findTasksByUserId($user_id)
{
    $sort_by = isset($_SESSION['sort_by']) ? $_SESSION['sort_by'] : 'title';
    $connection = connect();
    $sql = "select t.task_id, t.title, t.deadline, c.income as category_income, t.done from tasks t
left join categories c on t.category_id = c.category_id
where t.user_id=:user_id
ORDER BY ".$sort_by." ASC";
    $statement = $connection->prepare($sql);
    $statement->execute(array($user_id));
    return $statement;
}
function createUser($first_name, $last_name, $email, $password)
{
    $connection = connect();
    $sql = "INSERT INTO users (first_name, last_name, password, email) VALUES (:first_name, :last_name, :hash, :email)";
    $statement = $connection->prepare($sql);
    $hash = create_password_hash($password);
    $statement->execute(array($first_name, $last_name, $hash, $email));
    return $statement;
}
function createTask($user_id, $title, $dateArray, $category_id)
{
    $deadline = $dateArray == null ? null : $dateArray[2]. '-'. $dateArray[1]. '-' .$dateArray[0];
    $connection = connect();
    $sql = "INSERT INTO tasks (user_id, title, deadline, category_id)
    values (:user_id, :title, :deadline, :category_id )";
    $statement = $connection->prepare($sql);
    $statement->execute(array($user_id, $title, $deadline, $category_id));
    return $statement;
}
function findCategories($user_id)
{
    $connection = connect();
    $sql = "SELECT * from categories where user_id=:user_id";
    $statement = $connection->prepare($sql);
    $statement->execute(array($user_id));
    return $statement;
}
function updateTaskFinished($task_id, $user_id)
{
    $connection = connect();
    $sql = "UPDATE tasks SET done=true WHERE task_id=:task_id AND user_id=:user_id";
    $statement = $connection->prepare($sql);
    $statement->execute(array($task_id, $user_id));
    return $statement;
}
function deleteTask($task_id, $user_id)
{
    $connection = connect();
    $sql = "DELETE FROM tasks WHERE task_id=:task_id AND user_id=:user_id";
    $statement = $connection->prepare($sql);
    $statement->execute(array($task_id, $user_id));
    return $statement;
}
function createCategory($name, $user_id) {
    $connection = connect();
    $sql = "INSERT into categories (income, user_id) values (:income, :user_id)";
    $statement = $connection->prepare($sql);
    $statement->execute(array($name, $user_id));
    return $statement;
}
?>