-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Dim 04 Octobre 2015 à 14:54
-- Version du serveur :  5.5.34
-- Version de PHP :  5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `an_cms`
--

-- --------------------------------------------------------

--
-- Structure de la table `an_blog`
--

CREATE TABLE `an_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `online` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `an_blog`
--

INSERT INTO `an_blog` (`id`, `title`, `slug`, `content`, `created`, `online`) VALUES
(1, 'Saluut', 'saluut', '## Salut les coucouilles !\n![](http://localhost:8888/uploads/blog/2015/10/test2.jpg)\n\n\nJ''espère que ça marche la fonction autosave (local seulement ^^).\n\nOn va voir à 22h35................\njjjjj\nkkkj\n**kjkj**\nfasf\nsafafasfa\nfsfaf\nsffa\n\nasfafff\nfasa\n\n```\nvar example = "hello!";\nalert(example);\n```\n\nfsafa\nfsasf\nfasfa\nfsf\nafsfa\nsffsa\n\nfaafa\n...\n... >.<\nHi Ho Hu\nGluuuuuuuteeeeen\nBege', '0000-00-00 00:00:00', 0),
(2, 'test d''un article2', 'test-d-un-article2', 'voici un article de test\nsfsfa\nsafasf\n\nsafsaf', '0000-00-00 00:00:00', 1),
(3, 'test 2 ou pas ?', 'test-2-ou-pas', 'fsafafa', '2015-10-04 10:48:39', 1);

-- --------------------------------------------------------

--
-- Structure de la table `an_category`
--

CREATE TABLE `an_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `module` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `an_medias`
--

CREATE TABLE `an_medias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `file` varchar(255) NOT NULL,
  `module` varchar(20) NOT NULL,
  `ref_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `an_medias`
--

INSERT INTO `an_medias` (`id`, `name`, `file`, `module`, `ref_id`) VALUES
(1, 'test2', 'blog/2015/10/test2.jpg', 'blog', 1),
(4, 'avatar', 'blog/2015/10/avatar.jpg', 'blog', 1),
(3, 'bg', 'blog/2015/10/bg.jpg', 'blog', 1),
(5, 'test3', 'blog/2015/10/test3.jpg', 'blog', 1);

-- --------------------------------------------------------

--
-- Structure de la table `an_settings`
--

CREATE TABLE `an_settings` (
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `an_settings`
--

INSERT INTO `an_settings` (`name`, `value`) VALUES
('TITLE', 'ShinixCMS V0.0.1'),
('TEMPLATE', 'default');

-- --------------------------------------------------------

--
-- Structure de la table `an_users`
--

CREATE TABLE `an_users` (
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
(1, 'admin', '$2y$10$NSJBmPx3uZiAwS2CBL32Jel8LIcB7dRbpEwO3BtdjX.fZnKAQKcSK', 'admin@admin.com', 0, '2015-10-04 14:53:11');
