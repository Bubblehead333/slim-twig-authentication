# slim-twig-basic
<h2>Slim/Twig Basic Framework</h2>

This project contains the Slim framework and uses Twig templates to render views.
It is intended to be a convenient solution for building lightweight websites.

<h4>Guide</h4>

All public facing assets, so images, stylesheets, JavaScript is stored in the
public/ directory under the appropriate folder.
When pushing files to a web server, make sure the public directory on your web
server points to this directory.

Twig templates are stored in the resources/templates directory. This includes a
partials/ directory which can include headers and footers and the like. app.twig
is an important file as it sets up templates with common styling by linking
stylesheets, JavaScript, jQuery and any headers or footers.

The app/ directory includes the all important routes.php which allows you set
URLs for your site. These routes set the URLs and calls a particular method from
a class when that route is accessed. These can be used for API calls.

The Controllers directory which by default includes the HomeController class is
where you store the PHP or processing of your site. This in turn renders the
associated templates stored on resources/ and passes through any variables or
processing done when the method is called. HomeController can of course be
changed, this was just included so that it worked out of the box :)
