-- Adminer 4.8.1 MySQL 8.0.39 dump

SET NAMES utf8;
SET
time_zone = '+00:00';
SET
foreign_key_checks = 0;
SET
sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `id`         int          NOT NULL AUTO_INCREMENT,
    `username`   varchar(50)  NOT NULL,
    `email`      varchar(100) NOT NULL,
    `password`   varchar(255) NOT NULL,
    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`)
VALUES (1, 'gffgh', 'gssdfgss@gmail.com', '$2y$10$US7yKnByTKDhEaxJffhjCOcy3v2soTlIFfYSrcaxuMngJxPJ3av.6',
        '2024-10-07 08:48:46'),
       (2, 'hgfhg', 'jhgfjgalexis@gmail.com', '$2y$10$YtlEzhHQzs5zT7IdWk1O1.DdxNogMgXzXYP7ItcC.fqTMAY5mq.YW',
        '2024-10-07 08:51:12'),
       (3, 'fdsf', 'bondar@gmail.com', '$2y$10$1wI62JTpcZkBXS4/DWRiYekNK3PavXq8exa.WBr/PLZtdC5SdFM1S',
        '2024-10-08 09:52:17'),
       (5, 'aaa', 'sdfdsr@gmail.com', '$2y$10$wrah/eoLOCpcjRzlqKUxqeJGDC/joKsjI7ioHw3QSJL7g/.6GeNPq',
        '2024-10-08 09:54:39');

-- 2024-10-08 09:55:49