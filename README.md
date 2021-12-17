# ext-application

A base component to integrate Sencha Ext JS into a PHP application

[![Build Status](https://github.com/teqneers/ext-application/actions/workflows/php.yml/badge.svg)](https://github.com/teqneers/ext-application/actions/workflows/php.yml)

## Introduction

This library provides a simple abstraction around the different requirements when running Sencha Ext JS 6
(even though 5 should work as well) applications from a development and a production context using server generated
pages. Development and production builds use different source trees to serve application files from. This process is
based on a so-called [manifest and a Javascript micro-loader](http://docs.sencha.com/cmd/6.x/microloader.html). To make
sure this process works seamlessly with server generated pages and routing, the library hooks into the manifest
generation and dynamically modifies the manifest based on the required environment and context.

Currently this library is only used as the foundation
of [teqneers/ext-application-bundle](https://github.com/teqneers/ext-application-bundle), a Symfony bundle that
integrates Ext JS into a Symfony based application. We have not tried to use the library as a stand-alone component or
in any other context than a Symfony environment, so the following is only how it should work theoretically without the
bundle. We'd appreciate any help and contribution to make the library more useful outside the bundle.

## Installation

You can install this library using composer

    composer require teqneers/ext-application

or add the package to your composer.json file directly.

## Example

Given the following directory structure of a fictitious application

    ./
    |-- src/            Application source code
    |-- htdocs/         Public web-facing directory (document root)
    |   |-- index.php   PHP front controller
    |   |-- app/        Root folder for Ext JS application production build
    |-- my-app/         The Ext JS application source folder (sencha generate app -ext MyApp ./my-app)

you should configure your application (e.g. from index.php)

```php
$config = \TQ\ExtJS\Application\Configuration\ApplicationConfiguration(
    __DIR__ . '/../my-app',     // the absolute path to the Ext JS application workspace
    '../my-app',                // the relative path from the public web-facing directory to the Ext JS application workspace
    __DIR__,                    // the absolute path to the public web-facing directory
    '/'                         // the relative path from the  public web-facing directory to the root directory used for production build artifacts (usually /)
);

// add a default build
$config->addBuild(
    'default',          // the build name (just for referencing the build)
    '/',                // the application path relative to the Ext JS application workspace (usually / unless you have multiple applications and/or packages in a single workspace)
    'app',              // the application path relative to the root directory used for production build artifacts
    'manifest.json',    // the build manifest filename for development builds
    'bootstrap.js',     // the micro-loader filename for development builds
    null,               // the application cache manifest filename for development builds (usually NULL)
    'bootstrap.json',   // the build manifest filename for production builds
    'bootstrap.js',     // the micro-loader filename for production builds
    'cache.appcache'    // the application cache manifest filename fro production builds
);

$application = new \TQ\ExtJS\Application\Application(
    $config,
    new \TQ\ExtJS\Application\Manifest\ManifestLoader(),
    'dev' // dev or prod depending on wether you want to run from development or drom production build
);

$microLoader = $application->getMicroLoaderFile(); // returns a \SplFileInfo for the configured micro-loader
$hasAppCache = $application->hasAppCache();
if ($hasAppCache) {
    $appCache = $application->getAppCacheFile(); // returns a \SplFileInfo for the configured application cache manifest
}
$manifest    = $application->getManifest('/htdocs'); // returns a \TQ\ExtJS\Application\Manifest\Manifest configured correctly when running document root on your application base path

echo $manifest; // outputs the manifest
```

When running the application in development mode, you have to make sure that your web server's document root is one
level up from the (regular) public web-facing directory so that the web server can serve files from the Ext JS
application workspace as well.

## License

The MIT License (MIT)

Copyright (c) 2021 TEQneers GmbH & Co. KG

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit
persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
