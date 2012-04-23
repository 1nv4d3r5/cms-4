--
-- Table structure for table `cms_auth`
--

DROP TABLE IF EXISTS `cms_auth`;
CREATE TABLE `cms_auth` (
  `auth_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cookie` varchar(80) NOT NULL,
  PRIMARY KEY (`auth_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Table structure for table `cms_blog_entries`
--

DROP TABLE IF EXISTS `cms_blog_entries`;
CREATE TABLE `cms_blog_entries` (
  `blog_entry_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Author of blog entry.',
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `slug` text NOT NULL,
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`blog_entry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Table structure for table `cms_blog_entry_history`
--

DROP TABLE IF EXISTS `cms_blog_entry_history`;
CREATE TABLE `cms_blog_entry_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_entry_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `action` varchar(255) NOT NULL COMMENT 'Action performed on blog entry ("ADD", "EDIT", "DELETE", etc.)',
  `data` text NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `cms_menu`
-- Important Note: cms_menu REQUIRES InnoDB for transactional purposes that
-- MyISAM cannot provide.
--

DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `page_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_menu`
--

LOCK TABLES `cms_menu` WRITE;
INSERT INTO `cms_menu` VALUES (1,1);
UNLOCK TABLES;

--
-- Table structure for table `cms_modules`
--

DROP TABLE IF EXISTS `cms_modules`;
CREATE TABLE `cms_modules` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_modules`
--
-- TODO: There's a lot to do for modules, but for now, just set module names.
-- In the future, modules will be able to be installed/uninstalled.
--

LOCK TABLES `cms_modules` WRITE;
INSERT INTO `cms_modules` VALUES (1,'blog');
UNLOCK TABLES;

--
-- Table structure for table `cms_page_history`
--

DROP TABLE IF EXISTS `cms_page_history`;
CREATE TABLE `cms_page_history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `action` varchar(255) NOT NULL COMMENT 'Action performed on page ("ADD", "EDIT", "DELETE", etc.)',
  `data` text NOT NULL,
  PRIMARY KEY (`history_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Table structure for table `cms_pages`
--

DROP TABLE IF EXISTS `cms_pages`;
CREATE TABLE `cms_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `date_created` datetime NOT NULL,
  `default` tinyint(1) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `slug` text NOT NULL,
  `deletable` tinyint(1) NOT NULL DEFAULT '1',
  `editable` tinyint(1) DEFAULT '1',
  `module_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_pages`
--

LOCK TABLES `cms_pages` WRITE;
INSERT INTO `cms_pages` VALUES
(1,'Home','<p>This is the default page. To edit the content in this page, visit the <a href=\"admin\">administration page</a>.</p>',NOW(),1,1,'home',1,1,NULL),
(2,'Blog Entries','',NOW(),0,1,'blog/entries',0,0,1);
UNLOCK TABLES;

--
-- Table structure for table `cms_settings`
--

DROP TABLE IF EXISTS `cms_settings`;
CREATE TABLE `cms_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  PRIMARY KEY (`setting_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_settings`
--

LOCK TABLES `cms_settings` WRITE;
INSERT INTO `cms_settings` VALUES
    (1,'site_name','Austin\'s CMS'),
    (2,'blog_entry_date_format','F d, Y');
UNLOCK TABLES;

--
-- Table structure for table `cms_users`
--

DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(40) NOT NULL COMMENT 'SHA-1 Hash',
  `email` varchar(255) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `archived` tinyint(1) NOT NULL DEFAULT '0',
  `permission_manage_users` tinyint(1) NOT NULL DEFAULT '0',
  `permission_pages_edit` tinyint(1) NOT NULL DEFAULT '0',
  `permission_pages_add` tinyint(1) NOT NULL DEFAULT '0',
  `permission_blog_entry_edit` tinyint(1) NOT NULL DEFAULT '0',
  `permission_blog_entry_add` tinyint(1) NOT NULL DEFAULT '0',
  `permission_blog_entry_credit_users` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cms_users`
--

LOCK TABLES `cms_users` WRITE;
INSERT INTO `cms_users` VALUES
    (1,'Admin','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','admin@email.com','Firstname','Lastname',0,1,1,1,1,1,1);
UNLOCK TABLES;
