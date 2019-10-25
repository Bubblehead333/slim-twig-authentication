# slim-twig-basic
<h2>Slim/Twig Authentication</h2>

This project builds upon the lightweight Slim framework and uses Twig templates
to render views. It is intended to be a convenient solution for building
lightweight websites with small databases storing user information.

The repository contains:
Slim - http://www.slimframework.com/
Twig - https://twig.symfony.com/
Laravel (Eloquent) - https://laravel.com/

<b>This project is still a work in progress</b>

<h2>Guide</h2>

<h4>Public</h4>
All public facing assets, so images, stylesheets, JavaScript is stored in the
public/ directory under the appropriate folder.
When pushing files to a web server, make sure the public directory on your web
server points to this directory.

<h4>Templates</h4>
Twig templates are stored in the resources/templates directory. This includes a
partials/ directory which can include headers and footers and the like. app.twig
is an important file as it sets up templates with common styling by linking
stylesheets, JavaScript, jQuery and any headers or footers.

The app/ directory includes the all important routes.php which allows you set
URLs for your site. These routes set the URLs and calls a particular method from
a class when that route is accessed. These can be used for API calls.

The Controllers directory which by default includes the HomeController class is
where you can query the database using Eloquent and/or store the PHP or processing
of your site.
This in turn renders the associated templates stored on resources/ and passes
through any variables or processing done when the method is called.
HomeController can of course be changed, this was just included so that it
worked out of the box :)

<h4>Database</h4>

The database connector can be found in app.php, at the time of writing these
credentials are raw text and are NOT secure. This project attempts to connect to
a MySQL database called 'your-database-name'. I would also recommend you change
this :)

It is intended that the database is queried through the Controller classes under
App/. Eloquent's documentation can be found here:
https://laravel.com/docs/5.8/eloquent

<h4>Validation</h4>

Uses Respect's validation tool: https://github.com/Respect/Validation
List of available validation rules can be found here: https://respect-validation.readthedocs.io/en/1.1/list-of-rules/
