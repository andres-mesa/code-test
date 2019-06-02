code-test
=========

**Pasos para instalar y ejecutar esta prueba** 

    git clone https://github.com/andres-mesa/code-test.git
    
    cd code-test
    
    composer install

En el directorio raiz del proyecto, crear BBDD y actualizar el esquema:

    php bin/console doctrine:database:create

    php bin/console doctrine:schema:update --force

Cargar datos de prueba

    php bin/console doctrine:fixtures:load
    
Test unitarios 
    
    phpunit
    
    
**Notas**

Requiere PHP 7.1

