<?php

class User
{
    private $email;
    private $password;

    private static $table = 'users';

    function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    function insert($conn)
    {
        $query = "INSERT INTO " . User::$table . " (id, email, password) VALUES (NULL, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $this->email, $this->password);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    static function find_by_email($conn, $email)
    {
        $query = "SELECT * FROM " . User::$table . " WHERE email=?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return null;
        }

        $user = $result->fetch_assoc();
        return $user;
    }

    static function is_email_available($conn, $email)
    {
        $query = "SELECT * FROM " . User::$table . " WHERE email=?";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows !== 0) {
            return false;
        }
        return true;
    }
}
