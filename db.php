<?php

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
require_once __DIR__ . ("/helpers.php");


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

    public function query(string $query) {
        mysqli_query($this->connection, $query);
    }

    public function select(string $query, array $parameters = [])
    {
        $statement = db_get_prepare_stmt($this->connection, $query, $parameters);
        if (!$statement) {
            $error = mysqli_error($this->connection);
            echo "Ошибка MySQL" . $error;
            die;
        }
        mysqli_stmt_execute($statement);
        $result = mysqli_stmt_get_result($statement);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        return $data;
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

    public function update(string $query, array $data = []): void {
        $this->insert($query, $data);
    }

    public function insertData(string $table, array $data): void
    {
        $query = sprintf('INSERT INTO %s (%s) values (%s)',
            $table,
            implode(',', array_keys($data)),
            implode(',', array_fill(0, count($data), '?'))
        );

        $this->insert($query, $data);
    }

    public function updateData(string $table, array $data): void
    {
//        $query= sprintf('UPDATE %s SET (%s)',$table,
//            $data,
//            implode(',', array_keys($data)),
//            $media);
//
//
//        $this->insert($query, $data);
    }

}

$DB = new Db();
global $DB;




