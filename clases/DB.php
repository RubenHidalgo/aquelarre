<?php

    require_once('Config.php');
    require_once('User.php');
    require_once('Game.php');
    require_once('UserGame.php');

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

        public static function getUserId($id_user) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user WHERE id_user = ?");
                if ($sql->execute(array($id_user))) {
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

        public static function setNick($nick, $newnick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("UPDATE user SET nick=? WHERE nick=?");
                $sql->bindParam(1, $newnick);
                $sql->bindParam(2, $nick);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setPass($nick, $pass) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("UPDATE user SET pass=? WHERE nick=?");
                $sql->bindParam(1, $pass);
                $sql->bindParam(2, $nick);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setAbout($nick, $about) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("UPDATE user SET about=? WHERE nick=?");
                $sql->bindParam(1, $about);
                $sql->bindParam(2, $nick);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setGame($name, $about) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO game (nameg, about) VALUES (?, ?)");
                $sql->bindParam(1, $name);
                $sql->bindParam(2, $about);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setUserGame($id_user, $id_game, $director) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO user_game (id_user, id_game, director) VALUES (?, ?, ?)");
                $sql->bindParam(1, $id_user);
                $sql->bindParam(2, $id_game);
                $sql->bindParam(3, $director);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getGame($nameg) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game WHERE nameg = ?");
                if ($sql->execute(array($nameg))) {
                    while ($row = $sql->fetch()) {
                        $game = new Game($row);
                    }
                }
                return $game;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getGames() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game");
                if ($sql->execute(array())) {
                    while ($row = $sql->fetch()) {
                        $games[] = new Game($row);
                    }
                }
                return $games;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }


        public static function getGameId($id_game) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game WHERE id_game = ?");
                if ($sql->execute(array($id_game))) {
                    while ($row = $sql->fetch()) {
                        $game = new Game($row);
                    }
                }
                return $game;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getUsersGame($id_game) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user_game WHERE id_game = ?");
                if ($sql->execute(array($id_game))) {
                    while ($row = $sql->fetch()) {
                        $userGame[] = new UserGame($row);
                    }
                }
                return $userGame;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getGamesUser($id_user) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user_game WHERE id_user = ?");
                if ($sql->execute(array($id_user))) {
                    while ($row = $sql->fetch()) {
                        $userGame[] = new UserGame($row);
                    }
                }
                return $userGame;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

    }
?>