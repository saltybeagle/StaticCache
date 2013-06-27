#Static Cache
A caching library that uses the filesystem for storing cached output
in static files which can be served by Apache.

Many PHP applications use Apache's *mod_rewrite* to create clean URLs. Typically
this involves rewriting requests for missings files to index.php. When this
happens, PHP translates the route, generates the content and responds.

Smart people cache the result to improve speed. This takes the idea one step
further by writing the output to the filesystem, so subsequent requests do not
need to be interpreted by PHP.

For example:

	GET /people/124

For this request, the cache key is `/people/124`, **StaticCache** will write the output to `/var/www/html/people/124` and subsequent requests will not be sent to PHP for interpretation, allowing Apache to do what it does well — serve
static content.

Emptying the cache is as simple as removing the `/var/www/html/people` directory, and a utility such as **tmpwatch** can be used to automate emptying the cache:

	tmpwatch 2 /var/www/html/people

That command will remove everything in the `people` directory that is more than two hours old.

##Advice on URL Structures


A couple warnings for collection URLs and sub-paths.

The following sequence requires the `people` _file_ to be converted to a _directory_:

	GET /people
	GET /people/123

The first request will create a `people` file, the subsequent request requires
that the people file be converted to `people/index.html`.

Susequent requests to `/people` will (usually) be redirected to `/people/` and
will serve up `people/index.html`.

As a tip, reference collections using a trailing slash.

	GET /people/
	GET /people/123

For more information on this, read the [Apache documentation on mod_dir's DirectorySlash option](http://httpd.apache.org/docs/2.0/mod/mod_dir.html#DirectorySlash).

Also, querystring requests will go to the original file:

	GET /people/123?format=json

*actually* loads:

    /var/www/html/people/123

This is why it is important to use file extensions in the urls:

	GET /people/123.json
    
If you do not use file extensions, be sure to set your default content type correctly, e.g. in `.htaccess`:

	DefaultType "text/html; charset=utf-8"

##Comparisons to Jekyll

**StaticCache** can be used to generate a static site, similar to Jekyll. Combining this library with a simple web crawler (like [Spider](https://github.com/saltybeagle/Spider "A simple web crawler in PHP")) and you'll have a dynamic site=>static site conversion utility like Jekyll.

##Installation
Clone the git repository and for a quick start, make sure your web root is writable by the web user. Include the following in the beginning of your PHP script:

```php
<?php
require_once __DIR__.'/path/to/StaticCache/src/StaticCache.php';
StaticCache::autoCache();

echo 'This page was cached at '.date('Y-m-d H:i:s');
```

See the examples directory for how to use **StaticCache**.


