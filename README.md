code-test
=========

**Steps to run this app:**

Clone the repository, install dependencies via composer

    git clone https://github.com/andres-mesa/code-test.git
    
    cd code-test
    
    composer install

While prompt to fulfill the database parameters keep the default values, then:

    php bin/console doctrine:database:create

    php bin/console doctrine:schema:update --force

Load DataFixtures

    php bin/console doctrine:fixtures:load
    
Unit tests
    
    phpunit
    
    
**Notes**

Requires PHP 7.1

