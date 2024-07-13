
CREATE DATABASE IF NOT EXISTS `dcache`;

USE `dcache`;

DROP TABLE IF EXISTS `dc-data`;

CREATE TABLE `dc-data` (
  `id` int NOT NULL,
  `token` tinytext NOT NULL,
  `name` tinytext CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `value` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `dc-data` (`id`, `token`, `name`, `value`) VALUES
(1, 'testdata', 'firstname', 'Max'),
(2, 'testdata', 'lastname', 'Mustermann'),
(3, 'testdata', 'temperature', '21'),
(4, 'testdata', 'humidity', '65.5');

ALTER TABLE `dc-data`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `dc-data`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

SELECT * FROM `dc-data`;
