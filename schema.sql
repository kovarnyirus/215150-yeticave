CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE category (
  id       INT AUTO_INCREMENT PRIMARY KEY,
  category CHAR(50)
);

CREATE TABLE lot (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  lot_create     DATETIME,
  name           CHAR(70)  NOT NULL,
  description    TEXT      NOT NULL,
  lot_img        CHAR(100) NOT NULL,
  initial_price  INT       NOT NULL,
  completio_date DATE      NOT NULL,
  step           INT       NOT NULL
);

CREATE TABLE bet (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  bet_date   DATE NOT NULL,
  user_price INT  NOT NULL
);

CREATE TABLE user (
  id                INT AUTO_INCREMENT PRIMARY KEY,
  data_registration DATETIME,
  email             CHAR(30) NOT NULL UNIQUE,
  name              CHAR(30) NOT NULL,
  password          CHAR(68) NOT NULL UNIQUE,
  avatar            CHAR(60) null,
  contacts          CHAR(50) null
);
