CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(50) NOT NULL
)
  ENGINE = InnoDB
  CHARACTER SET = UTF8;

CREATE TABLE bets (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  bet_date   DATE NOT NULL,
  user_price INT  NOT NULL
)
  ENGINE = InnoDB,
  CHARACTER SET = UTF8;

CREATE TABLE users (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  created_date DATETIME,
  email        VARCHAR(30) NOT NULL UNIQUE,
  name         VARCHAR(30) NOT NULL,
  password     VARCHAR(68) NOT NULL UNIQUE,
  avatar       VARCHAR(60) NULL,
  contacts     VARCHAR(50) NULL
)
  ENGINE = InnoDB,
  CHARACTER SET = UTF8;

CREATE TABLE lots (
  id             INT AUTO_INCREMENT PRIMARY KEY,
  created_date   DATETIME,
  name           VARCHAR(70)  NOT NULL,
  description    TEXT         NOT NULL,
  lot_img        VARCHAR(100) NOT NULL,
  initial_price  INT          NOT NULL,
  completio_date DATE         NOT NULL,
  step           INT          NOT NULL,
  winner_id      INT          NOT NULL,
  user_id        INT          NOT NULL,
  category_id    INT          NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories (id)
    ON UPDATE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users (id)
    ON UPDATE CASCADE,
  FOREIGN KEY (winner_id) REFERENCES users (id)
    ON UPDATE CASCADE
)
  ENGINE = InnoDB,
  CHARACTER SET = UTF8;

CREATE UNIQUE INDEX user_email
  ON users (email);
CREATE UNIQUE INDEX category_name
  ON categories (category_name);
