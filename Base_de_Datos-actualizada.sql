/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.5.13 : Database - facturacion
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`facturacion` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `facturacion`;

/*Table structure for table `cliente` */

DROP TABLE IF EXISTS `cliente`;

CREATE TABLE `cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_cliente` varchar(40) NOT NULL,
  `apellido_cliente` varchar(40) NOT NULL,
  `cuil_cliente` varchar(11) NOT NULL,
  `iva_cliente` varchar(2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_cliente` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificacion_cliente` timestamp NOT NULL DEFAULT '2015-05-31 07:46:08',
  `estado_cliente` varchar(1) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `cliente_a_usuario` (`id_usuario`),
  CONSTRAINT `cliente_a_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `cliente` */

insert  into `cliente`(`id_cliente`,`nombre_cliente`,`apellido_cliente`,`cuil_cliente`,`iva_cliente`,`id_usuario`,`creacion_cliente`,`modificacion_cliente`,`estado_cliente`) values (2,'Emanuel','Guirao','2147483648','M',2,'2015-05-31 02:24:46','2015-05-20 17:45:36','A'),(3,'Juan','Grillo','12345678','RI',2,'2015-05-31 07:40:41','2015-05-31 07:40:41','B'),(4,'PPP','KKKK','12345678','RI',2,'2015-05-31 07:40:41','2015-05-31 07:40:41','B'),(5,'asdfa','asdfasdf','1213123072','RI',2,'2015-05-31 07:50:41','2015-05-31 07:50:41','A'),(6,'Diego','Bilyk','12312311808','MO',2,'2015-05-31 08:02:21','2015-05-31 08:02:21','A'),(7,'UNO','MAS','0','NI',2,'2015-05-31 07:50:41','2015-05-31 08:06:15','A'),(8,'UNO','MAS','98765438976','NI',2,'2015-05-31 07:50:41','2015-05-31 08:07:20','A'),(9,'Otra','Prueba','98765438976','NI',2,'2015-05-31 07:50:41','2015-05-31 08:09:02','A'),(10,'Otra','Prueba','-18807932','NI',2,'2015-05-31 07:50:41','2015-05-31 08:11:17','A'),(11,'Otra','Prueba','98765438976','NI',2,'2015-05-31 07:50:41','2015-05-31 08:11:52','A'),(12,'Otra','Prueba','-18807932','NI',2,'2015-05-31 08:12:55','2015-05-31 08:12:55','A'),(13,'Otra','Prueba','-18807932','NI',2,'2015-05-31 08:13:58','2015-05-31 08:13:58','A'),(14,'Prueba','CUIT_String','98765439876','NI',2,'2015-05-31 14:48:09','2015-05-31 14:48:09','A'),(15,'Desde','Modal','12345678901','mo',2,'2015-05-31 21:55:16','2015-05-31 21:55:16','A'),(16,'2Desde','Modal','09876543212','RI',2,'2015-05-31 22:10:06','2015-05-31 22:10:06','A'),(17,'3roDesde','Modal','12345678908','RI',2,'2015-05-31 22:16:00','2015-05-31 22:16:00','A'),(18,'TOMAS','LAZARTE','12345678909','MO',2,'2015-06-01 21:43:49','2015-06-01 21:43:49','A');

/*Table structure for table `correo` */

DROP TABLE IF EXISTS `correo`;

CREATE TABLE `correo` (
  `id_correo` int(11) NOT NULL AUTO_INCREMENT,
  `email_correo` varchar(100) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `estado_correo` varchar(1) NOT NULL,
  PRIMARY KEY (`id_correo`),
  KEY `correo_a_cliente` (`id_cliente`),
  CONSTRAINT `correo_a_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `correo` */

insert  into `correo`(`id_correo`,`email_correo`,`id_cliente`,`estado_correo`) values (1,'emanuelguirao@gmail.com',2,'');

/*Table structure for table `detalle_factura` */

DROP TABLE IF EXISTS `detalle_factura`;

CREATE TABLE `detalle_factura` (
  `id_detalle_factura` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_detalle_factura` int(7) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  `estado_detalle_factura` varchar(1) NOT NULL,
  PRIMARY KEY (`id_detalle_factura`),
  KEY `FK_detalle_factura` (`id_factura`),
  KEY `FK_detalle_factura_prod` (`id_producto`),
  CONSTRAINT `FK_detalle_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detalle_factura_prod` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_factura` */

insert  into `detalle_factura`(`id_detalle_factura`,`cantidad_detalle_factura`,`id_producto`,`id_factura`,`estado_detalle_factura`) values (1,4,1,1,''),(2,5,2,1,'');

/*Table structure for table `domicilio` */

DROP TABLE IF EXISTS `domicilio`;

CREATE TABLE `domicilio` (
  `id_domicilio` int(11) NOT NULL AUTO_INCREMENT,
  `calle_domicilio` varchar(50) NOT NULL,
  `numero_domicilio` int(6) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_localidad` int(11) NOT NULL,
  `id_provincia` int(11) NOT NULL,
  `piso_domicilio` int(2) DEFAULT NULL,
  `departamento_domicilio` varchar(2) DEFAULT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_domicilio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_domicilio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_domicilio` varchar(1) NOT NULL,
  PRIMARY KEY (`id_domicilio`),
  KEY `domicilio_a_usuario` (`id_usuario`),
  KEY `domiclio_a_cliente` (`id_cliente`),
  KEY `domiclio_a_localidad` (`id_localidad`),
  KEY `domicilio_a_provincia` (`id_provincia`),
  CONSTRAINT `domicilio_a_provincia` FOREIGN KEY (`id_provincia`) REFERENCES `provincia` (`id_provincia`),
  CONSTRAINT `domicilio_a_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `domiclio_a_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `domiclio_a_localidad` FOREIGN KEY (`id_localidad`) REFERENCES `localidad` (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `domicilio` */

insert  into `domicilio`(`id_domicilio`,`calle_domicilio`,`numero_domicilio`,`id_cliente`,`id_localidad`,`id_provincia`,`piso_domicilio`,`departamento_domicilio`,`id_usuario`,`creacion_domicilio`,`modificacion_domicilio`,`estado_domicilio`) values (1,'Alfredo Bufano',3423,2,1,1,NULL,NULL,2,'2015-05-20 17:53:06','2015-05-20 17:53:06','');

/*Table structure for table `factura` */

DROP TABLE IF EXISTS `factura`;

CREATE TABLE `factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `numero_factura` int(11) NOT NULL,
  `creacion_factura` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_factura` char(1) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `modificacion_factura` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_factura` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `FK_factura` (`id_usuario`),
  KEY `FK_factura_cli` (`id_cliente`),
  CONSTRAINT `FK_factura` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_factura_cli` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `factura` */

insert  into `factura`(`id_factura`,`numero_factura`,`creacion_factura`,`tipo_factura`,`id_cliente`,`id_usuario`,`modificacion_factura`,`estado_factura`) values (1,1,'2015-05-20 18:05:57','B',2,2,'2015-05-20 18:05:57',NULL);

/*Table structure for table `localidad` */

DROP TABLE IF EXISTS `localidad`;

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_localidad` varchar(40) NOT NULL,
  `estado_localidad` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `localidad` */

insert  into `localidad`(`id_localidad`,`nombre_localidad`,`estado_localidad`) values (1,'Capital',NULL),(2,'San Martin',NULL),(3,'Guaymallen',NULL),(4,'Godoy Cruz',NULL),(5,'San Rafael',NULL),(6,'General Alvear',NULL),(7,'Lavalle',NULL),(8,'Malargue',NULL),(9,'San Carlos',NULL),(10,'Tupungato',NULL),(11,'Tunuyan',NULL),(12,'Santa Rosa',NULL),(13,'Rivadavia',NULL),(14,'Junin',NULL),(15,'Las Heras',NULL),(16,'Maipu',NULL);

/*Table structure for table `precio` */

DROP TABLE IF EXISTS `precio`;

CREATE TABLE `precio` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `monto_precio` int(5) NOT NULL,
  `id_historico_precio` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `creacion_precio` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificacion_precio` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_precio` varchar(1) NOT NULL,
  PRIMARY KEY (`id_precio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `precio` */

/*Table structure for table `precio_historico` */

DROP TABLE IF EXISTS `precio_historico`;

CREATE TABLE `precio_historico` (
  `id_precio_historico` int(11) NOT NULL AUTO_INCREMENT,
  `precio_precio_historico` decimal(10,2) NOT NULL,
  `creacion_precio_historico` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_precio_historico` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado_precio_historico` varchar(1) NOT NULL,
  PRIMARY KEY (`id_precio_historico`),
  KEY `FK_precio_historico` (`id_producto`),
  KEY `FK_precio_historico_user` (`id_usuario`),
  CONSTRAINT `FK_precio_historico` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `FK_precio_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `precio_historico` */

insert  into `precio_historico`(`id_precio_historico`,`precio_precio_historico`,`creacion_precio_historico`,`modificacion_precio_historico`,`id_producto`,`id_usuario`,`estado_precio_historico`) values (1,'15.23','2015-05-20 17:59:23','2015-05-20 17:59:23',1,2,''),(2,'12.99','2015-05-20 17:59:44','2015-05-20 17:59:44',2,2,'');

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_producto` varchar(250) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_producto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_producto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_producto` varchar(1) NOT NULL,
  PRIMARY KEY (`id_producto`),
  KEY `FK_producto` (`id_usuario`),
  CONSTRAINT `FK_producto` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `producto` */

insert  into `producto`(`id_producto`,`descripcion_producto`,`id_usuario`,`creacion_producto`,`modificacion_producto`,`estado_producto`) values (1,'Coca-Cola 1,5 L',2,'2015-05-20 17:55:29','2015-05-20 17:55:29',''),(2,'Sprite 1,5 L',2,'2015-05-20 17:55:52','2015-05-20 17:55:52','');

/*Table structure for table `provincia` */

DROP TABLE IF EXISTS `provincia`;

CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_provincia` varchar(40) NOT NULL,
  `estado_provincia` varchar(1) NOT NULL,
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

/*Data for the table `provincia` */

insert  into `provincia`(`id_provincia`,`nombre_provincia`,`estado_provincia`) values (1,'Mendoza',''),(2,'San Juan',''),(3,'San Luis',''),(4,'La Pampa',''),(5,'Neuquen',''),(6,'La Rioja',''),(7,'Jujuy',''),(8,'Catamarca',''),(9,'Formosa',''),(10,'Chaco',''),(11,'Misiones',''),(12,'Tucuman',''),(13,'Santiago del Estero',''),(14,'Misiones',''),(15,'Entre Rios',''),(16,'Buenos Aires',''),(17,'Cordoba',''),(18,'Santa Fe',''),(19,'Rio Negro',''),(20,'Chubut',''),(21,'Salta',''),(22,'Santa Cruz',''),(23,'Tierra del Fuego','');

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `existencia_stock` int(7) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_stock` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_stock` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_stock` varchar(1) NOT NULL,
  PRIMARY KEY (`id_stock`),
  KEY `FK_stock` (`id_usuario`),
  KEY `FK_stock_prod` (`id_producto`),
  CONSTRAINT `FK_stock` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`),
  CONSTRAINT `FK_stock_prod` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `stock` */

insert  into `stock`(`id_stock`,`existencia_stock`,`id_producto`,`id_usuario`,`creacion_stock`,`modificacion_stock`,`estado_stock`) values (1,253,1,2,'2015-05-20 18:01:29','2015-05-20 18:01:29',''),(2,75,2,2,'2015-05-20 18:02:01','2015-05-20 18:02:01','');

/*Table structure for table `telefono` */

DROP TABLE IF EXISTS `telefono`;

CREATE TABLE `telefono` (
  `id_telefono` int(11) NOT NULL AUTO_INCREMENT,
  `numero_telefono` varchar(15) NOT NULL,
  `tipo_telefono` varchar(2) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `estado_telefono` varchar(1) NOT NULL,
  PRIMARY KEY (`id_telefono`),
  KEY `telefono_a_cliente` (`id_cliente`),
  CONSTRAINT `telefono_a_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `telefono` */

/*Table structure for table `usuario` */

DROP TABLE IF EXISTS `usuario`;

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(15) NOT NULL,
  `pass_usuario` varchar(45) NOT NULL,
  `acceso_usuario` varchar(1) NOT NULL,
  `creacion_usuario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_usuario` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `estado_usuario` varchar(1) NOT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`nombre_usuario`,`pass_usuario`,`acceso_usuario`,`creacion_usuario`,`modificacion_usuario`,`estado_usuario`) values (2,'flaco','8354336224c63279aadd00a9621757ef4fdf31fc','A','2015-05-31 22:45:31','2015-05-20 17:28:04',''),(3,'diego','8354336224c63279aadd00a9621757ef4fdf31fc ','A','2015-05-31 22:42:36','0000-00-00 00:00:00','A');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
