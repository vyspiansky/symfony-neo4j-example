Symfony Example using neo4j
===========================

This is a simple example of using Neo4j with symfony2.8.

Setup
--------------

In order to do the RESTful connection to the DB it's necessary to set this 
variables in app/config/parameters.yml. These are the "default values". 

  * neo4j-host: localhost
  * neo4j-port: 7474
  * neo4j-user: neo4j
  * neo4j-pass: your-password

It uses the graphaware bundles

You can find other information in my blog -> [mentatik.com](http://mentatik.com/blog/)

Run Built-in web server
--------------

$ cd ~/Web/symfony-neo4j-example/web
$ php -S localhost:8000 app_dev.php