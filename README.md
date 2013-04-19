A caching library that uses the filesystem for storing cached output
in static files which can be served by Apache.

Many PHP applications use Apache's mod_rewrite to create clean URLs. Typically
this involves rewriting requests for missings files to index.php. When this
happens, PHP translates the route, generates the content and responds.

Smart people cache the result to improve speed. This takes the idea one step
further by writing the output to the filesystem, so subsequent requests do not
need to be interpreted by PHP.

For example:
GET /people/124

For this request, the cache key is /people/124, StaticCache will write the 
output to /var/www/html/people/124 and subsequent requests will not be sent
to PHP for interpretation, allowing Apache to do what it does best, serve
static content.

Emptying the cache is as simple as removing the /var/www/html/people directory,
and a utility such as tmpwatch can be used to automate emptying the cache:

`tmpwatch 2 /var/www/html/people`

Remove everything in the `people` directory that is more than two hours old.

A couple warnings for collection URLs and sub-paths.

The following sequence requires the people file to be converted to a directory:
GET /people
GET /people/123

The first request will create a people file, the subsequent request requires
that the people file be converted to people/index.html.

Susequent requests to /people will (usually) be redirected to /people/ and
will serve up people/index.html.

As a tip, reference collections using a trailing slash.

GET /people/
GET /people/123

Also, querystring requests will go to the original file:
GET /people/123?format=json will pull /var/www/html/people/123

This is why it is important to use file extensions in the urls:
GET /people/123.json
