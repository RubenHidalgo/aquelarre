<?php

    require_once('Config.php');
    require_once('User.php');
    require_once('Game.php');
    require_once('UserGame.php');
    require_once('Log.php');
    require_once('Post.php');

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

        // Método que obtiene la lista de usuarios
        public static function getUsersNickDesc() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user ORDER BY nick DESC");
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

        // Método que obtiene la lista de usuarios
        public static function getUsersNickAsc() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user ORDER BY nick ASC");
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

        // Método que obtiene la lista de usuarios
        public static function getUsersASC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user ORDER BY fecha ASC");
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

        // Método que obtiene la lista de usuarios
        public static function getUsersDESC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user ORDER BY fecha DESC");
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

        public static function setNivel($nivel, $id_user_game) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("UPDATE user_game SET nivel=? WHERE id_user_game=?");
                $sql->bindParam(1, $nivel);
                $sql->bindParam(2, $id_user_game);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setLogNick($nick, $newnick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("UPDATE log SET nick=? WHERE nick=?");
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

        public static function setUserGame($id_user, $id_game, $director, $clase, $nivel, $vida, $nombre) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO user_game (id_user, id_game, director, clase, vida, nivel, nombre) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $sql->bindParam(1, $id_user);
                $sql->bindParam(2, $id_game);
                $sql->bindParam(3, $director);
                $sql->bindParam(4, $clase);
                $sql->bindParam(5, $vida);
                $sql->bindParam(6, $nivel);
                $sql->bindParam(7, $nombre);
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

        public static function getGamesDESC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game ORDER BY created DESC");
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

        public static function getGamesASC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game ORDER BY created ASC");
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

        public static function getGamesNombreASC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game ORDER BY nameg ASC");
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

        public static function getGamesNombreDESC() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM game ORDER BY nameg ASC");
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

        public static function getUserNombre($nombre) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user_game WHERE nombre = ?");
                if ($sql->execute(array($nombre))) {
                    while ($row = $sql->fetch()) {
                        $userGame = new UserGame($row);
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

        public static function getGamesNotUser($id_user) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user_game WHERE id_user NOT LIKE ?");
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

        public static function getLog($nick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM log WHERE nick = ? ORDER BY acceso DESC");
                if ($sql->execute(array($nick))) {
                    while ($row = $sql->fetch()) {
                        $log[] = new Log($row);
                    }
                }
                return $log;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getLastLog($nick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM log WHERE nick = ? ORDER BY acceso DESC LIMIT 1");
                if ($sql->execute(array($nick))) {
                    while ($row = $sql->fetch()) {
                        $log = new Log($row);
                    }
                }
                return $log;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setLog($nick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO log (nick) VALUES (?)");
                $sql->bindParam(1, $nick);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function delUser($nick) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("DELETE FROM user WHERE nick = ?");
                $sql->bindParam(1, $nick);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function delUserGame($id) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("DELETE FROM user_game WHERE id_user = ?");
                $sql->bindParam(1, $id);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function getGamesDirector($id_user) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM user_game WHERE id_user = ? AND director = 1");
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

        public static function delGame($id_game) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("DELETE FROM game WHERE id_game = ?");
                $sql->bindParam(1, $id_game);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function delGameUser($id_game) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("DELETE FROM user_game WHERE id_game = ?");
                $sql->bindParam(1, $id_game);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function setPost($title, $picture, $body_text) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("INSERT INTO post (title, picture, body_text) VALUES (?, ?, ?)");
                $sql->bindParam(1, $title);
                $sql->bindParam(2, $picture);
                $sql->bindParam(3, $body_text);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        // Método que obtiene la lista de usuarios
        public static function getPosts() {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM post ORDER BY created DESC");
                if ($sql->execute(array())) {
                    while ($row = $sql->fetch()) {
                        $posts[] = new Post($row);
                    }
                }
                return $posts;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        // Método que obtiene la información de un post
        public static function getPost($id_post) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("SELECT * FROM post WHERE id_post = ?");
                if ($sql->execute(array($id_post))) {
                    while ($row = $sql->fetch()) {
                        $post = new Post($row);
                    }
                }
                return $post;
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

        public static function delPost($id_post) {
            $conexion = self::getConnection();
            try {
                $sql = $conexion->prepare("DELETE FROM post WHERE id_post = ?");
                $sql->bindParam(1, $id_post);
                $sql->execute();
            } catch (PDOException $e) {
                echo "ERROR: " . $e->getMessage();
            }
        }

    }
?>

