-- MySQL dump 10.13  Distrib 5.7.12, for Linux (x86_64)
--
-- Host: localhost    Database: wmf
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `lang`
--

DROP TABLE IF EXISTS `lang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lang` (
  `en` varchar(255) NOT NULL,
  `uk` varchar(255) NOT NULL,
  `bg` varchar(255) NOT NULL,
  PRIMARY KEY (`en`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lang`
--

LOCK TABLES `lang` WRITE;
/*!40000 ALTER TABLE `lang` DISABLE KEYS */;
INSERT INTO `lang` VALUES ('already exists','вже існує','вече съществува'),('and','а також','както и'),('can only','можливо тільки','може само'),('characters)','символів)','знака)'),('client and server validation','клієнтська та серверна валідація','валидиране клиент и сървър'),('crop','кадрувати','реколта'),('E-mail','Електронна пошта','Електронна поща'),('home','головна','основен'),('Implementing MVC-pattern without using php-frameworks','Реалізація MVC-патерну без використання php-фреймворків','Изпълнение MVC-модел без използване на PHP-рамки'),('Incorrect e-mail address','Неправильна адреса електронної пошти','Неправилно имейл адрес'),('Incorrect e-mail or password','Неправильна адреса електронної пошти або пароль','Неправилно електронна поща или парола'),('is required','Це обов\'язкове поле','Това поле е задължително'),('is too big (maximum','є занадто великим (максимум','е прекалено голям (максимална'),('is too short (minimum','є занадто коротким (мінімум','е твърде кратък (минимум'),('language','мова','език'),('login','Ввійти','Влизане'),('logout','вийти','Изход'),('multi-language interface','багатомовний інтерфейс','многоезичен интерфейс'),('Name','Iм\'я','Име'),('Password','Пароль','Парола'),('Passwords are not equal','Паролі не збігаються','Паролите не са равни'),('photo','фото','снимка'),('profile','профіль','профил'),('registration','реєстрація','регистрация'),('registration and login/logout user','реєстрація та вхід/вихід користувача','регистрация и вход/изход потребител'),('Registration date','Дата реєстрації','Дата на регистрация'),('Repeat password','Повторити пароль','Повторете паролата'),('Submit','Відправити','Изпращам'),('support sessions and cookies','підтримка сесій і куки','подкрепа сесии и куки'),('Too big file size (maximum ','Занадто великий розмір файлу (максимум ','Прекалено голям размер на файла (максимална '),('Upload','Завантажити','качи снимка'),('View the Project on GitHub','Перегляд проекту на GitHub','Преглед на проекта на GitHub'),('Wrong type of file','Неправильний тип файлу','Грешен тип на файла');
/*!40000 ALTER TABLE `lang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` varchar(45) NOT NULL,
  `cdate` int(11) NOT NULL,
  `picture` varchar(150) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_email` (`email`(10))
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-26 19:11:48
