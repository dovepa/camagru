<?php

// edit bitnami.conf and add :
// DocumentRoot "/Users/dpalombo/http/camagru"
// <Directory "/Users/dpalombo/http/camagru">
// for sent mail uncomment sendmail_path = "env -i /usr/sbin/sendmail -t -i" in php.ini

include "database.php";

try {
    $db = new PDO("mysql:host=127.0.0.1:3306", $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE `camagru_dpalombo`";
    $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error database creation :".$e->getMessage()."\n";
        die();
    }

try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `users` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `username` VARCHAR(50) NOT NULL,
          `mail` VARCHAR(100) NOT NULL,
          `passwd` VARCHAR(255) NOT NULL,
          `token` VARCHAR(50) NOT NULL,
          `mailcom` INT NOT NULL DEFAULT '1',
          `verified` INT NOT NULL DEFAULT '0'
        )";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error user table creation :".$e->getMessage()."\n";
    }

try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `img` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT(11) NOT NULL,
          `linkimg` VARCHAR(100) NOT NULL,
          `ts` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
          FOREIGN KEY (userid) REFERENCES users(id)
        )";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error gallery :".$e->getMessage()."\n";
    }

try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `com` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT(11) NOT NULL,
          `imgid` INT(11) NOT NULL,
          `comment` VARCHAR(255) NOT NULL,
          FOREIGN KEY (userid) REFERENCES users(id),
          FOREIGN KEY (imgid) REFERENCES img(id)
        )";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error com table :".$e->getMessage()."\n";
    }

    try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `like` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT(11) NOT NULL,
          `imgid` INT(11) NOT NULL,
          `likeval` INT(2) NOT NULL,
          FOREIGN KEY (userid) REFERENCES users(id),
          FOREIGN KEY (imgid) REFERENCES img(id)
        )";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error like table :".$e->getMessage()."\n";
    }

try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE TABLE `comment` (
          `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
          `userid` INT(11) NOT NULL,
          `imgid` INT(11) NOT NULL,
          `comment` VARCHAR(255) NOT NULL,
          FOREIGN KEY (userid) REFERENCES users(id),
          FOREIGN KEY (imgid) REFERENCES img(id)
        )";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error comment table :".$e->getMessage()."\n";
    }

    try {
        $db = new PDO($DB_DNS, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `users` (`id`, `username`, `mail`, `passwd`, `token`, `verified`) VALUES
        ('1', 'dove', 'test@dfd.fr', '123456', '111', '1')";
        $db->exec($sql);
    } catch (PDOException $e) {
        echo "Error user table creation :".$e->getMessage()."\n";
    }

?>
