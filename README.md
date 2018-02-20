Symfony Example using neo4j
===========================

This is a simple example of using Neo4j with symfony2.8.

Original repository - https://github.com/Margaferrez/symfony-neo4j-example

Setup
--------------

In order to do the RESTful connection to the DB it's necessary to set this 
variables in app/config/parameters.yml. These are the "default values". 

  * neo4j-host: localhost
  * neo4j-port: 7474
  * neo4j-user: neo4j
  * neo4j-pass: your-password

It uses the graphaware bundles

Run built-in web server
--------------

```$ cd ~/Web/symfony-neo4j-example/web```

```$ php -S localhost:8000 app_dev.php```
