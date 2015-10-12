-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:8889
-- Généré le :  Lun 12 Octobre 2015 à 16:28
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `an_cms`
--

-- --------------------------------------------------------

--
-- Structure de la table `an_blog`
--

CREATE TABLE IF NOT EXISTS `an_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `online` tinyint(1) NOT NULL,
  `img_id` int(11) NOT NULL,
  `slider` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `an_blog`
--

INSERT INTO `an_blog` (`id`, `title`, `slug`, `content`, `created`, `online`, `img_id`, `slider`) VALUES
(1, 'Saluut', 'saluut', '## Salut les coucouilles !\n![](http://localhost/ShinixCMS/uploads/blog/2015/10/bg_200x200.jpg)\n\nJ''espère que ça marche la fonction autosave (local seulement ^^).\n\nOn va voir à 22h35................\njjjjj\nkkkj\n**kjkj**\nfasf\nsafafasfa\nfsfaf\nsffa\n\nasfafff\nfasa\n\n```\nvar example = "hello!";\nalert(example);\n```\n\nfsafa\nfsasf\nfasfa\nfsf\nafsfa\nsffsa\n\nfaafa\n...\n... >.<\nHi Ho Hu\nGluuuuuuuteeeeen\nBege', '0000-00-00 00:00:00', 1, 1, 1),
(2, 'test d''un article2', 'test-d-un-article2', 'voici un article de test\nsfsfa\nsafasf\n\nsafsaf', '0000-00-00 00:00:00', 1, 0, 0),
(3, 'test 2 ou pas ?', 'test-2-ou-pas', 'fsafafa', '2015-10-04 10:48:39', 1, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `an_category`
--

CREATE TABLE IF NOT EXISTS `an_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `an_medias`
--

CREATE TABLE IF NOT EXISTS `an_medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `module` varchar(20) NOT NULL,
  `ref_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `an_medias`
--

INSERT INTO `an_medias` (`id`, `name`, `file`, `module`, `ref_id`) VALUES
(1, 'bg', 'blog/2015/10/bg.jpg', 'blog', 1);

-- --------------------------------------------------------

--
-- Structure de la table `an_pages`
--

CREATE TABLE IF NOT EXISTS `an_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `online` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `an_settings`
--

CREATE TABLE IF NOT EXISTS `an_settings` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `an_settings`
--

INSERT INTO `an_settings` (`name`, `value`) VALUES
('TITLE', 'ShinixCMS V0.0.1'),
('TEMPLATE', 'default'),
('LANGUAGE', 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `an_users`
--

CREATE TABLE IF NOT EXISTS `an_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(80) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `an_users`
--

INSERT INTO `an_users` (`id`, `username`, `password`, `email`, `level`, `created`) VALUES
(1, 'admin', '$2y$10$NSJBmPx3uZiAwS2CBL32Jel8LIcB7dRbpEwO3BtdjX.fZnKAQKcSK', 'admin@admin.com', 9, '2015-10-04 14:53:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
