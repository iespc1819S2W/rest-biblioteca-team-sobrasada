# rest-biblioteca-team-sobrasada
Llegir tots els llibres. (GET) jordi FET<br>
llibreTots.php<br>
<br>
Llegir un llibre a partir de la clau primària. (GET) miguel FET<br>
Llegir un llibre amb filtres i ordenació (GET) xavi<br>
Alta d’un llibre. (POST)  xavi FET<br><br>
Modificar un llibre (POST) alex FET<br>
modificarLlibre.php
Parametros:<br>
idLlibre exemple:1<br>
titol exemple:"titulo de libro"<br>
numEdicio exemple:1ª<br>
llocEdicio exemple:"mallorca"<br>
anyEdicio exemple:2009 <br>
descripcio exemple:"descripcio aleatoria" <br>
isbn exemple: "9P8-84-K66AA8-77-1"<br>
deplegal exemple:"PM-1.196-2018" <br>
signtop exemple:"P. CAT-CAR-PJS" <br>
dataBaixa exemple:"2003-10-15 00:00:00"<br>
motiuBaixa exemple:"obsolet"<br>
fkCollecio exemple: "EDIC. Y DISTRIBUCIONES UNIVERSITARIAS" <br>
fkDepartament exemple:"Castellà" <br>
fkIdEditor exemple: 89 <br>
fkLlengua exemple:"Catalana"<br>
imatge exemple:"/path/to/image"<br>

Borrar un llibre(POST)alex FET<br>
borrarLlibre.php
idLlibre exemple:8202<br><br>
Llegir tots els autors d’un llibre. (GET )miguel FET<br>
Alta d’un nou autor d’un llibre (POST) jordi FET<br>
autorLlibreAlta.php<br>
Parametros:<br>
id_llibre exemple:1<br>
id_autor exemple:2<br>
<br>
Baixa d’un autor d’un determinat llibre (POST) jordi FET<br>
autorLlibreDel.php<br>
Parametros:<br>
id_llibre exemple:1<br>
id_autor exemple:2<br>
