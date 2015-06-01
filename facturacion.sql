/*
SQLyog Enterprise - MySQL GUI v7.13 
MySQL - 5.6.16 : Database - facturacion
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
  `cuil_cliente` int(11) NOT NULL,
  `iva_cliente` varchar(2) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_cliente` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_cliente` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_cliente`),
  KEY `cliente_a_usuario` (`id_usuario`),
  CONSTRAINT `cliente_a_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `cliente` */

insert  into `cliente`(`id_cliente`,`nombre_cliente`,`apellido_cliente`,`cuil_cliente`,`iva_cliente`,`id_usuario`,`creacion_cliente`,`modificacion_cliente`) values (2,'Emanuel','Guirao',2147483647,'M',2,'2015-05-20 17:45:36','2015-05-20 17:45:36');

/*Table structure for table `correo` */

DROP TABLE IF EXISTS `correo`;

CREATE TABLE `correo` (
  `id_correo` int(11) NOT NULL AUTO_INCREMENT,
  `email_correo` varchar(100) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_correo`),
  KEY `correo_a_cliente` (`id_cliente`),
  CONSTRAINT `correo_a_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `correo` */

insert  into `correo`(`id_correo`,`email_correo`,`id_cliente`) values (1,'emanuelguirao@gmail.com',2);

/*Table structure for table `detalle_factura` */

DROP TABLE IF EXISTS `detalle_factura`;

CREATE TABLE `detalle_factura` (
  `id_detalle_factura` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_detalle_factura` int(7) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_factura` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_factura`),
  KEY `FK_detalle_factura` (`id_factura`),
  KEY `FK_detalle_factura_prod` (`id_producto`),
  CONSTRAINT `FK_detalle_factura_prod` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_detalle_factura` FOREIGN KEY (`id_factura`) REFERENCES `factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_factura` */

insert  into `detalle_factura`(`id_detalle_factura`,`cantidad_detalle_factura`,`id_producto`,`id_factura`) values (1,4,1,1),(2,5,2,1);

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

insert  into `domicilio`(`id_domicilio`,`calle_domicilio`,`numero_domicilio`,`id_cliente`,`id_localidad`,`id_provincia`,`piso_domicilio`,`departamento_domicilio`,`id_usuario`,`creacion_domicilio`,`modificacion_domicilio`) values (1,'Alfredo Bufano',3423,2,1,1,NULL,NULL,2,'2015-05-20 17:53:06','2015-05-20 17:53:06');

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
  PRIMARY KEY (`id_factura`),
  KEY `FK_factura` (`id_usuario`),
  KEY `FK_factura_cli` (`id_cliente`),
  CONSTRAINT `FK_factura_cli` FOREIGN KEY (`id_cliente`) REFERENCES `cliente` (`id_cliente`),
  CONSTRAINT `FK_factura` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `factura` */

insert  into `factura`(`id_factura`,`numero_factura`,`creacion_factura`,`tipo_factura`,`id_cliente`,`id_usuario`,`modificacion_factura`) values (1,1,'2015-05-20 18:05:57','B',2,2,'2015-05-20 18:05:57');

/*Table structure for table `localidad` */

DROP TABLE IF EXISTS `localidad`;

CREATE TABLE `localidad` (
  `id_localidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_localidad` varchar(40) NOT NULL,
  PRIMARY KEY (`id_localidad`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `localidad` */

insert  into `localidad`(`id_localidad`,`nombre_localidad`) values (1,'Capital');

/*Table structure for table `precio_historico` */

DROP TABLE IF EXISTS `precio_historico`;

CREATE TABLE `precio_historico` (
  `id_precio_historico` int(11) NOT NULL AUTO_INCREMENT,
  `precio_precio_historico` decimal(10,2) NOT NULL,
  `creacion_precio_historico` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_precio_historico` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  PRIMARY KEY (`id_precio_historico`),
  KEY `FK_precio_historico` (`id_producto`),
  KEY `FK_precio_historico_user` (`id_usuario`),
  CONSTRAINT `FK_precio_historico` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `FK_precio_historico_user` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `precio_historico` */

insert  into `precio_historico`(`id_precio_historico`,`precio_precio_historico`,`creacion_precio_historico`,`modificacion_precio_historico`,`id_producto`,`id_usuario`) values (1,'15.23','2015-05-20 17:59:23','2015-05-20 17:59:23',1,2),(2,'12.99','2015-05-20 17:59:44','2015-05-20 17:59:44',2,2);

/*Table structure for table `producto` */

DROP TABLE IF EXISTS `producto`;

CREATE TABLE `producto` (
  `id_producto` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_producto` varchar(250) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_producto` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_producto` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_producto`),
  KEY `FK_producto` (`id_usuario`),
  CONSTRAINT `FK_producto` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `producto` */

insert  into `producto`(`id_producto`,`descripcion_producto`,`id_usuario`,`creacion_producto`,`modificacion_producto`) values (1,'Coca-Cola 1,5 L',2,'2015-05-20 17:55:29','2015-05-20 17:55:29'),(2,'Sprite 1,5 L',2,'2015-05-20 17:55:52','2015-05-20 17:55:52');

/*Table structure for table `provincia` */

DROP TABLE IF EXISTS `provincia`;

CREATE TABLE `provincia` (
  `id_provincia` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_provincia` varchar(40) NOT NULL,
  PRIMARY KEY (`id_provincia`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `provincia` */

insert  into `provincia`(`id_provincia`,`nombre_provincia`) values (1,'Mendoza');

/*Table structure for table `stock` */

DROP TABLE IF EXISTS `stock`;

CREATE TABLE `stock` (
  `id_stock` int(11) NOT NULL AUTO_INCREMENT,
  `existencia_stock` int(7) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `creacion_stock` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modificacion_stock` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_stock`),
  KEY `FK_stock` (`id_usuario`),
  KEY `FK_stock_prod` (`id_producto`),
  CONSTRAINT `FK_stock_prod` FOREIGN KEY (`id_producto`) REFERENCES `producto` (`id_producto`),
  CONSTRAINT `FK_stock` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `stock` */

insert  into `stock`(`id_stock`,`existencia_stock`,`id_producto`,`id_usuario`,`creacion_stock`,`modificacion_stock`) values (1,253,1,2,'2015-05-20 18:01:29','2015-05-20 18:01:29'),(2,75,2,2,'2015-05-20 18:02:01','2015-05-20 18:02:01');

/*Table structure for table `telefono` */

DROP TABLE IF EXISTS `telefono`;

CREATE TABLE `telefono` (
  `id_telefono` int(11) NOT NULL AUTO_INCREMENT,
  `numero_telefono` varchar(15) NOT NULL,
  `tipo_telefono` varchar(2) NOT NULL,
  `id_cliente` int(11) NOT NULL,
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
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `usuario` */

insert  into `usuario`(`id_usuario`,`nombre_usuario`,`pass_usuario`,`acceso_usuario`,`creacion_usuario`,`modificacion_usuario`) values (2,'flaco','flaco','A','2015-05-20 17:28:04','2015-05-20 17:28:04');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
