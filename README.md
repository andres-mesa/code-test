code-test
=========

**Pasos para instalar y ejecutar esta prueba** 

    composer install

Cambiar parametros de la BBDD en app/parameters.yml si es necesario

En el directorio raiz del proyecto:

    php bin/console doctrine:database:create

    php bin/console doctrine:schema:update --force

Cargar datos de prueba

    php bin/console doctrine:fixtures:load
    
Test unitarios 
    
    phpunit
    
    
**Notas**

Requiere PHP >=5.5.9 aunque se ha desarrollado con la versión 7.1

