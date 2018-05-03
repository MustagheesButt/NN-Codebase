CREATE TABLE IF NOT EXISTS `accounts.users` (
 `user_id` bigint(20) unsigned NOT NULL,
 `email` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
 `full_name` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
 `profile_pic` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
 `rank` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'New',
 `about_me` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `registered_on` date NOT NULL,
 UNIQUE KEY `user_id` (`user_id`),
 UNIQUE KEY `email` (`email`(200))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `users.tests` (
 `counter` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
 `user_id` bigint(20) unsigned NOT NULL,
 `test_id` tinytext COLLATE utf8mb4_unicode_ci NOT NULL,
 `source_index` int(11) NOT NULL,
 `subjects` mediumtext COLLATE utf8mb4_unicode_ci,
 `score` int(10) NOT NULL,
 `total` int(10) NOT NULL,
 `time_taken` int(11) NOT NULL,
 `date` date NOT NULL,
 `answers` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
 `public` tinyint(1) NOT NULL DEFAULT '1',
 PRIMARY KEY (`counter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `ads` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `image` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `publisher` text COLLATE utf8mb4_unicode_ci NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `stats.ads` (
 `ad_id` int(10) unsigned NOT NULL,
 `views` int(10) unsigned NOT NULL,
 `clicks` int(10) unsigned NOT NULL,
 PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `stats.trending_data` (
 `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `views` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
 `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;