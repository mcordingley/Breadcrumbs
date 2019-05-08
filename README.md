# Breadcrumbs

[![Build Status](https://api.travis-ci.org/repositories/mcordingley/Breadcrumbs.svg)](https://travis-ci.org/mcordingley/Breadcrumbs)
[![Code Climate](https://codeclimate.com/github/mcordingley/Breadcrumbs/badges/gpa.svg)](https://codeclimate.com/github/mcordingley/Breadcrumbs)
[![Code Climate](https://codeclimate.com/github/mcordingley/Breadcrumbs/badges/coverage.svg)](https://codeclimate.com/github/mcordingley/Breadcrumbs)

## Installation and Configuration

Breadcrumbs is a simple plugin for Laravel to DRY up your breadcrumb routes and names. Start by installing it through
Composer.

```
composer require mcordingley/breadcrumbs
```

The package automatically registers its service provider and facade, so the only remaining step is to publish the 
configuration and sample breadcrumb definition file.

```
php artisan vendor:publish
```

This will create `config/breadcrumbs.php` and `resources/breadcrumbs.json`. If you are using the default settings, there
is no need to alter the configuration file or create new entries in your .env file.

The JSON file contains your individual breadcrumb entries, with the routes as keys. Each entry must have a `title`
attribute and if the page belongs under another page then it should also have a `parent` attribute with the route of the
parent page. The library uses this to recursively find previous breadcrumbs from the current page.

If an entry in the JSON file contains the pattern `{foo}`, the text is replaced by a property `foo` that you pass
into the breadcrumb when making it. This pattern also supports dotted notation to pull nested properties.

By default, the breadcrumbs are formatted for use with Bootstrap. If you require a different format, set
`BREADCRUMBS_VIEW` in your .env file with the name of whatever view you wish to use instead.

## Usage

Within your views, simply call `make` on the `Breadcrumb` facade with your crumb path and optionally any parameters
required to format the path and title. As the output is a string and will contain HTML, you will want to use the
unescaped `{!! !!}` tags to output your crumbs. All values injected into the output should already be escaped by the
template view.

`{!! Breadcrumb::make('/foo/{foo.id}/edit', ['foo' => ['id' => 4, 'name' => 'Four']) !!}`