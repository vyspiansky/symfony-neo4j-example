Symfony Example using neo4j
===========================

This is a simple example of using Neo4j with Symfony 2.8.

Original repository - https://github.com/Margaferrez/symfony-neo4j-example

Setup
--------------

In order to do the RESTful connection to the DB it's necessary to set this 
variables in app/config/parameters.yml. These are the "default values". 

  * neo4j-host: localhost
  * neo4j-port: 7474
  * neo4j-user: neo4j
  * neo4j-pass: your-password

It uses the graphaware bundles.

Easiest way to play with the example
--------------

a) Go to the web folder of the project

```$ cd /path/to/project/web```

b) Run a built-in web server

```$ php -S localhost:8000 app_dev.php```

c) Visit http://localhost:8000/admin/user

Note! Neo4j server must be runned.
