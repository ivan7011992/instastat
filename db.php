<?php


class Db
{
    private $connection;

    public function __construct()
    {
        $this->connection = mysqli_connect("localhost", "root", "root", "instastat");

        if ($this->connection === false) {
            print("Ошибка подключения:" . mysqli_connect_error());
            die;
        }

        mysqli_set_charset($this->connection, "utf8");
    }

    public function select(string $query)
    {
        $result = mysqli_query($this->connection, $query);
        if (!$result) {
            $error = myqli_error($this->connection);
            echo "Ошибка MySQL" . $error;
            die;
        }
        $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $results;
    }

    public function insert(string $query, array $data): void
    {
        $stmt = db_get_prepare_stmt($this->connection, $query, $data);
        if (!$stmt) {
            $errors = mysqli_error($this->connection);
            echo "Ошибка MySQL:" . $errors;
            die;
        }
        $insertResult = mysqli_stmt_execute($stmt);
        if (!$insertResult) {
            $errors = mysqli_stmt_error($stmt);
            echo "Ошибка MySQL:" . $errors;
            die;
        }
    }
}

$DB = new Db();
global $DB;




