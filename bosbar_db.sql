-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2024 at 08:36 PM
-- Server version: 10.3.24-MariaDB-1:10.3.24+maria~bionic
-- PHP Version: 7.2.34-39+ubuntu18.04.1+deb.sury.org+1
CREATE DATABASE IF NOT EXISTS `local` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `local`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 3,
  `username` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `full_name` varchar(128) NOT NULL DEFAULT '',
  `session_id` varchar(64) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL,
  `random` varchar(128) NOT NULL DEFAULT '',
  `joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) DEFAULT 0 COMMENT 'actief of niet',
  `deleted` tinyint(1) unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY (`username`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_type` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) NOT NULL DEFAULT '',
  `deleted` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `main_perm_id` (`main_perm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `role_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `permission_id` int(11) NOT NULL DEFAULT 0,
  `deleted` tinyint(2) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `role_id` (`role_id`),
  KEY `permission_id` (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;