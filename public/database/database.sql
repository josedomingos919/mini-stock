-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: ministock
-- ------------------------------------------------------
-- Server version	5.7.31

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
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `data_` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Bebidas','2021-08-30 03:12:45'),(3,'Latarias','2021-08-30 03:13:54');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_categoria` int(11) DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  `preco_compra` double DEFAULT '0',
  `preco_venda` double DEFAULT '0',
  `preco_revendedor` double DEFAULT '0',
  `quantidade` int(11) DEFAULT '0',
  `data_` datetime DEFAULT CURRENT_TIMESTAMP,
  `foto` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome_UNIQUE` (`nome`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produto`
--

LOCK TABLES `produto` WRITE;
/*!40000 ALTER TABLE `produto` DISABLE KEYS */;
INSERT INTO `produto` VALUES (1,1,'Coca Cola',1000,3000,5000,30,'2021-08-30 03:14:29','3008210218570.jfif'),(2,3,'Fanta de Laranja',4000,3000,2000,30,'2021-08-30 03:15:15','3008210221070.jfif'),(3,3,'Salsicha de galinha',2000,2000,3900,30,'2021-08-30 03:16:07','3008210216070.jfif'),(4,3,'Shoriço',4000,3000,3000,40,'2021-08-30 03:16:30','3008210216300.jfif'),(5,3,'Salsicha de mino',2000,2000,4000,3,'2021-08-30 03:17:32','3008210217320.jfif'),(6,3,'Cuca',150,1200,200,23,'2021-08-30 03:18:14','3008210218140.jfif');
/*!40000 ALTER TABLE `produto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtovenda`
--

DROP TABLE IF EXISTS `produtovenda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtovenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `produto_id` int(11) DEFAULT NULL,
  `venda_id` int(11) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `preco` int(11) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `data_` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtovenda`
--

LOCK TABLES `produtovenda` WRITE;
/*!40000 ALTER TABLE `produtovenda` DISABLE KEYS */;
INSERT INTO `produtovenda` VALUES (1,6,1,1,1200,1200,'2021-09-05 11:55:07'),(2,5,2,4,2000,8000,'2021-09-05 11:55:19'),(3,6,2,4,1200,4800,'2021-09-05 11:55:19'),(4,6,3,1,1200,1200,'2021-09-05 11:56:07'),(5,6,4,2,1200,2400,'2021-09-05 11:56:29'),(6,5,5,3,2000,6000,'2021-09-05 13:12:20'),(7,6,5,3,1200,3600,'2021-09-05 13:12:20'),(8,2,6,5,3000,15000,'2021-09-05 13:12:57');
/*!40000 ALTER TABLE `produtovenda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `venda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` enum('DINHEIRO','TPA') NOT NULL,
  `data_` datetime DEFAULT CURRENT_TIMESTAMP,
  `estado` enum('vendido','cancelado','pedente') NOT NULL,
  `total` double NOT NULL,
  `valor_pago` double NOT NULL,
  `troco` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `venda`
--

LOCK TABLES `venda` WRITE;
/*!40000 ALTER TABLE `venda` DISABLE KEYS */;
INSERT INTO `venda` VALUES (1,'DINHEIRO','2021-09-05 11:55:06','vendido',1200,456789,455589),(2,'DINHEIRO','2021-09-05 11:55:19','vendido',12800,234567,221767),(3,'DINHEIRO','2021-09-05 11:56:07','vendido',1200,34568,33368),(4,'DINHEIRO','2021-09-05 11:56:29','vendido',2400,234534,232134),(5,'TPA','2021-09-05 13:12:20','vendido',9600,12000,2400),(6,'DINHEIRO','2021-09-05 13:12:57','vendido',15000,60000,45000);
/*!40000 ALTER TABLE `venda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vwapuramento`
--

DROP TABLE IF EXISTS `vwapuramento`;
/*!50001 DROP VIEW IF EXISTS `vwapuramento`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `vwapuramento` AS SELECT 
 1 AS `id`,
 1 AS `produtoID`,
 1 AS `tipo`,
 1 AS `foto`,
 1 AS `nomeProduto`,
 1 AS `quantidade`,
 1 AS `totalVenda`,
 1 AS `preco_compra`,
 1 AS `lucro`,
 1 AS `data_`,
 1 AS `year_`,
 1 AS `month_`,
 1 AS `day_`,
 1 AS `date_`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'ministock'
--

--
-- Dumping routines for database 'ministock'
--

--
-- Final view structure for view `vwapuramento`
--

/*!50001 DROP VIEW IF EXISTS `vwapuramento`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vwapuramento` AS select `venda`.`id` AS `id`,`produto`.`id` AS `produtoID`,`venda`.`tipo` AS `tipo`,`produto`.`foto` AS `foto`,`produto`.`nome` AS `nomeProduto`,sum(`produtovenda`.`quantidade`) AS `quantidade`,sum(`produtovenda`.`total`) AS `totalVenda`,sum((`produto`.`preco_compra` * `produtovenda`.`quantidade`)) AS `preco_compra`,(sum(`produtovenda`.`total`) - sum((`produto`.`preco_compra` * `produtovenda`.`quantidade`))) AS `lucro`,`venda`.`data_` AS `data_`,year(`venda`.`data_`) AS `year_`,month(`venda`.`data_`) AS `month_`,dayofmonth(`venda`.`data_`) AS `day_`,cast(`venda`.`data_` as date) AS `date_` from ((`venda` left join `produtovenda` on((`produtovenda`.`venda_id` = `venda`.`id`))) left join `produto` on((`produto`.`id` = `produtovenda`.`produto_id`))) group by `produto`.`id` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-09-05 13:56:09
