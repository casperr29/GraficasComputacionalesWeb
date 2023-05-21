CREATE DATABASE IF NOT EXISTS CRAZY_RAZER_DB;

-- SELECT 'Caso_default' as PLAYER_NAME, 00000 as PLAYER_SCORE;

USE CRAZY_RAZER_DB;
  
DROP TABLE IF EXISTS SINGLEPLAYER_TIME_SCORES;
CREATE TABLE `CRAZY_RAZER_DB`.`SINGLEPLAYER_TIME_SCORES` (
  `PLAYER_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla SINGLEPLAYER_TIME_SCORES',
  `PLAYER_NAME` VARCHAR(75) NOT NULL COMMENT 'Nombre del usuario',
  `PLAYER_SCORE` INT NOT NULL COMMENT 'Puntuacion del usuario',
  PRIMARY KEY (`PLAYER_ID`))DEFAULT CHARSET = utf8 COLLATE= utf8_unicode_ci;
  
  DROP TABLE IF EXISTS SINGLEPLAYER_OBJECTS_SCORES;
CREATE TABLE `CRAZY_RAZER_DB`.`SINGLEPLAYER_OBJECTS_SCORES` (
  `PLAYER_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla SINGLEPLAYER_OBJECTS_SCORES',
  `PLAYER_NAME` VARCHAR(75) NOT NULL COMMENT 'Nombre del usuario',
  `PLAYER_SCORE` INT NOT NULL COMMENT 'Puntuacion del usuario',
  PRIMARY KEY (`PLAYER_ID`))DEFAULT CHARSET = utf8 COLLATE= utf8_unicode_ci;
  
  DROP TABLE IF EXISTS MULTIPLAYER_TIME_SCORES;
CREATE TABLE `CRAZY_RAZER_DB`.`MULTIPLAYER_TIME_SCORES` (
  `PLAYER_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla MULTIPLAYER_TIME_SCORES',
  `PLAYER_NAME` VARCHAR(75) NOT NULL COMMENT 'Nombre del usuario',
  `PLAYER_SCORE` INT NOT NULL COMMENT 'Puntuacion del usuario',
  PRIMARY KEY (`PLAYER_ID`))DEFAULT CHARSET = utf8 COLLATE= utf8_unicode_ci;
  
  DROP TABLE IF EXISTS MULTIPLAYER_OBJECTS_SCORES;
CREATE TABLE `CRAZY_RAZER_DB`.`MULTIPLAYER_OBJECTS_SCORES` (
  `PLAYER_ID` INT NOT NULL AUTO_INCREMENT COMMENT 'Llave primaria de la tabla MULTIPLAYER_OBJECTS_SCORES',
  `PLAYER_NAME` VARCHAR(75) NOT NULL COMMENT 'Nombre del usuario',
  `PLAYER_SCORE` INT NOT NULL COMMENT 'Puntuacion del usuario',
  PRIMARY KEY (`PLAYER_ID`))DEFAULT CHARSET = utf8 COLLATE= utf8_unicode_ci;
  
  INSERT INTO SINGLEPLAYER_TIME_SCORES(PLAYER_NAME, PLAYER_SCORE) VALUES('KARIM', 100) ;
  
SELECT * FROM SINGLEPLAYER_TIME_SCORES;