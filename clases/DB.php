<?php

    require_once('Config.php');
    require_once('User.php');

    class DB {
        
        //Obtiene la conexión con la BBDD
        private static function getConnection() {
            $conexion = null;
            try {
                $conexion = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);

                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'ERROR - No se ha podido conectar con la BD: ' . $e->getMessage();
            }
            return $conexion;
        }

        // Método que obtiene la información de un usuario
        public static function getUser($nick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user WHERE nick = ?");
                if ($sql->execute(array($nick))) {
                    while ($row = $sql->fetch()) {
                        $user = new User($row);
                    }
                }
                return $user;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        // Método que obtiene la lista de usuarios
        public static function getUsers() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user");
                if ($sql->execute(array())) {
                    while ($row = $sql->fetch()) {
                        $users[] = new User($row);
                    }
                }
                return $users;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setUser($nick, $pass, $about) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO user (nick, pass, about) VALUES (?, ?, ?)");
                $sql->bindParam(1, $nick);
                $sql->bindParam(2, $pass);
                $sql->bindParam(3, $about);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }
    }
?>