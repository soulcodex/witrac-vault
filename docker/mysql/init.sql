CREATE DATABASE IF NOT EXISTS `witrac`;
CREATE DATABASE IF NOT EXISTS `witrac_test`;

CREATE USER 'witrac'@'%' IDENTIFIED BY 'witrac';
GRANT ALL PRIVILEGES ON `witrac`.* TO 'witrac'@'%';
GRANT ALL PRIVILEGES ON `witrac_test`.* TO 'witrac'@'%';
