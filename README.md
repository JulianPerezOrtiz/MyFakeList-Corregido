# MyFakeList
Proyecto PHP para la asignatura  Desarrollo Web en Entorno Servidor.

Disponible en https://porrista.es/myfakelist/index.php
## Introduccion

La web consiste en el seguimiento de series de anime, en la cual podras podras consultar informacion sobre series, añadirlas a tu lista de seguimiento con diferentes estados, ver listas y perfiles de otros usuarios, entre otras cosas. Se puede visitar la pagina sin estar registrado, pudiendo consultar toda la informacion de las series, ver los perfiles de otros usuarios y sus listas de seguimiento. En el caso de estar registrado, podras añadir series a tu seguimiento. 
La pagina esta diseñada en PHP, con motor de plantillas Twig, y Jquery y Ajax.

### Es necesario tener previamente el gestor plantillas Twig con "composer require "twig/twig:^3.0"

## Funcionamiento de la web

### Inicio
El inicio de la web empieza mostrando series aleatorias de la BD, de la cual se han obtenido a traves de la API https://jikan.docs.apiary.io/ la cual nos proporciona la mayoria de informacion sobre series de anime. A traves del buscador se pueden buscar series y usuarios registrados.

![alt text](https://i.imgur.com/johil8V.png)

### Pagina de series
Al entrar sobre una serie nos mostrara cierta informacion sobre esta, y segun si esta disponible o no. 
En caso de estar registrado, podremos añadir la serie a nuesta lista, por defecto se marca el estado para ver.

![alt text](https://i.imgur.com/3nEFS7X.png)

Si tenemos una serie en nuestra lista, podremos editar el estado, alternando entre viendo, para ver, droppeada y completada. Podremos marcar un episodio visto y en el caso de llegar al maximo de capitulos se marcara como visto automaticamente. 
Tambien podemos añadirle una puntuacion a la serie, borrar la serie de nuestra lista y añadirla a favoritos.

![alt text](https://i.imgur.com/xFzXqqw.png)

### Lista de Seguimiento

En la lista de seguimiento de nuestras series, nos la ordenara por estado, mostrando primero las que estamos viendo, las que tenemos para ver, droppeadas y completadas.
Desde aqui podremos editar directamente la puntuacion al pulsar sobre ella, la cual nos mostrara un desplegable para elegir la nota y se enviara al pinchar en otra parte. DE igual forma podremos sumar un capitulo visto, en el caso de esta la serie para ver o droppeada pasara a viendo, y al llegar al maximo de capitulos se marcara como completada. 
En la parte de comentarios, al pulsar sobre este nos aparecera un cuando con el mismo texto que teniamos para añadir notas sobre la serie y de la misma forma al pulsar en otra parte se enviara y se mostrara con el texto sin el input.
Tambien podemos ver la lista de otros usuarios.

![alt text](https://i.imgur.com/QV1UMof.png)

### Perfil

En la parte del perfil, tenemos varia informacion sobre este y sus series favoritas. 
Tambien podemos ver el perfil de otros usuarios.


![alt text](https://i.imgur.com/axPW86E.png)

En la parte de editar el perfil, contamos con poder editar su foto de perfil, ubicacion y descripcion.

![alt text](https://i.imgur.com/vTuvJ8f.png)

Ademas, contamos con un registro, en el cual verifica en el momento si el correo ya esta en uso o no y lo mismo con el alias.
