
-- Dumping structure for table invoice.invoice_details
CREATE TABLE IF NOT EXISTS `invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `invoice_id` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `rate` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `sub_total` varchar(100) NOT NULL,
  `o_tax` varchar(100) NOT NULL,
  `grand_total` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table invoice.invoice_details: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoice_details` DISABLE KEYS */;
INSERT INTO `invoice_details` (`id`, `customer_name`, `invoice_id`, `date`, `name`, `rate`, `quantity`, `tax`, `amount`, `sub_total`, `o_tax`, `grand_total`, `status`) VALUES
	(1, 'Boomi', '1', '07-04-2017', 'Apple', '10', '2', '0', '20.00', '525.00', '52.50', '577.50', '1'),
	(2, 'Boomi', '1', '07-04-2017', 'item', '100', '5', '1', '505.00', '525.00', '52.50', '577.50', '1');
/*!40000 ALTER TABLE `invoice_details` ENABLE KEYS */;

-- Dumping structure for table invoice.invoice_main
CREATE TABLE IF NOT EXISTS `invoice_main` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `last_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table invoice.invoice_main: ~0 rows (approximately)
/*!40000 ALTER TABLE `invoice_main` DISABLE KEYS */;
INSERT INTO `invoice_main` (`id`, `invoice_id`, `status`, `last_updated`) VALUES
	(1, 1, 1, '2017-04-07 07:26:26');
/*!40000 ALTER TABLE `invoice_main` ENABLE KEYS */;

-- Dumping structure for table invoice.item_details
CREATE TABLE IF NOT EXISTS `item_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `rate` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  `date` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Dumping data for table invoice.item_details: ~2 rows (approximately)
/*!40000 ALTER TABLE `item_details` DISABLE KEYS */;
INSERT INTO `item_details` (`id`, `item_name`, `rate`, `tax`, `date`, `status`) VALUES
	(1, 'Item', '100', '1', '14-06-2015', 1),
	(2, 'Apple', '10', '0', '14-06-2015', 1);
/*!40000 ALTER TABLE `item_details` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
