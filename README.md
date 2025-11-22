# CodeIgniter 4 Framework

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds the distributable version of the framework.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

You can read the [user guide](https://codeigniter.com/user_guide/)
corresponding to the latest version of the framework.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Contributing

We welcome contributions from the community.

Please read the [*Contributing to CodeIgniter*](https://github.com/codeigniter4/CodeIgniter4/blob/develop/CONTRIBUTING.md) section in the development repository.

## Server Requirements

PHP version 8.1 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

> [!WARNING]
> - The end of life date for PHP 7.4 was November 28, 2022.
> - The end of life date for PHP 8.0 was November 26, 2023.
> - If you are still using PHP 7.4 or 8.0, you should upgrade immediately.
> - The end of life date for PHP 8.1 will be December 31, 2025.

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

```
codeigniter4
├─ app
│  ├─ .htaccess
│  ├─ Common.php
│  ├─ Config
│  │  ├─ App.php
│  │  ├─ Autoload.php
│  │  ├─ Boot
│  │  │  ├─ development.php
│  │  │  ├─ production.php
│  │  │  └─ testing.php
│  │  ├─ Cache.php
│  │  ├─ Constants.php
│  │  ├─ ContentSecurityPolicy.php
│  │  ├─ Cookie.php
│  │  ├─ Cors.php
│  │  ├─ CURLRequest.php
│  │  ├─ Database.php
│  │  ├─ DocTypes.php
│  │  ├─ Email.php
│  │  ├─ Encryption.php
│  │  ├─ Events.php
│  │  ├─ Exceptions.php
│  │  ├─ Feature.php
│  │  ├─ Filters.php
│  │  ├─ ForeignCharacters.php
│  │  ├─ Format.php
│  │  ├─ Generators.php
│  │  ├─ Honeypot.php
│  │  ├─ Images.php
│  │  ├─ Kint.php
│  │  ├─ Logger.php
│  │  ├─ Migrations.php
│  │  ├─ Mimes.php
│  │  ├─ Modules.php
│  │  ├─ Optimize.php
│  │  ├─ Pager.php
│  │  ├─ Paths.php
│  │  ├─ Publisher.php
│  │  ├─ Routes.php
│  │  ├─ Routing.php
│  │  ├─ Security.php
│  │  ├─ Services.php
│  │  ├─ Session.php
│  │  ├─ Toolbar.php
│  │  ├─ UserAgents.php
│  │  ├─ Validation.php
│  │  └─ View.php
│  ├─ Controllers
│  │  ├─ BaseController.php
│  │  └─ Home.php
│  ├─ Database
│  │  ├─ Migrations
│  │  └─ Seeds
│  ├─ Filters
│  ├─ Helpers
│  ├─ index.html
│  ├─ Language
│  │  └─ en
│  │     └─ Validation.php
│  ├─ Libraries
│  ├─ Models
│  ├─ ThirdParty
│  └─ Views
│     ├─ errors
│     │  ├─ cli
│     │  │  ├─ error_404.php
│     │  │  ├─ error_exception.php
│     │  │  └─ production.php
│     │  └─ html
│     │     ├─ debug.css
│     │     ├─ debug.js
│     │     ├─ error_400.php
│     │     ├─ error_404.php
│     │     ├─ error_exception.php
│     │     └─ production.php
│     └─ welcome_message.php
├─ composer.json
├─ env
├─ LICENSE
├─ phpunit.xml.dist
├─ preload.php
├─ public
│  ├─ .htaccess
│  ├─ favicon.ico
│  ├─ index.php
│  └─ robots.txt
├─ README.md
├─ spark
├─ system
│  ├─ .htaccess
│  ├─ API
│  │  └─ ResponseTrait.php
│  ├─ Autoloader
│  │  ├─ Autoloader.php
│  │  ├─ FileLocator.php
│  │  ├─ FileLocatorCached.php
│  │  └─ FileLocatorInterface.php
│  ├─ BaseModel.php
│  ├─ Boot.php
│  ├─ bootstrap.php
│  ├─ Cache
│  │  ├─ CacheFactory.php
│  │  ├─ CacheInterface.php
│  │  ├─ Exceptions
│  │  │  └─ CacheException.php
│  │  ├─ FactoriesCache
│  │  │  └─ FileVarExportHandler.php
│  │  ├─ FactoriesCache.php
│  │  ├─ Handlers
│  │  │  ├─ BaseHandler.php
│  │  │  ├─ DummyHandler.php
│  │  │  ├─ FileHandler.php
│  │  │  ├─ MemcachedHandler.php
│  │  │  ├─ PredisHandler.php
│  │  │  ├─ RedisHandler.php
│  │  │  └─ WincacheHandler.php
│  │  └─ ResponseCache.php
│  ├─ CLI
│  │  ├─ BaseCommand.php
│  │  ├─ CLI.php
│  │  ├─ Commands.php
│  │  ├─ Console.php
│  │  ├─ Exceptions
│  │  │  └─ CLIException.php
│  │  ├─ GeneratorTrait.php
│  │  └─ InputOutput.php
│  ├─ CodeIgniter.php
│  ├─ Commands
│  │  ├─ Cache
│  │  │  ├─ ClearCache.php
│  │  │  └─ InfoCache.php
│  │  ├─ Database
│  │  │  ├─ CreateDatabase.php
│  │  │  ├─ Migrate.php
│  │  │  ├─ MigrateRefresh.php
│  │  │  ├─ MigrateRollback.php
│  │  │  ├─ MigrateStatus.php
│  │  │  ├─ Seed.php
│  │  │  └─ ShowTableInfo.php
│  │  ├─ Encryption
│  │  │  └─ GenerateKey.php
│  │  ├─ Generators
│  │  │  ├─ CellGenerator.php
│  │  │  ├─ CommandGenerator.php
│  │  │  ├─ ConfigGenerator.php
│  │  │  ├─ ControllerGenerator.php
│  │  │  ├─ EntityGenerator.php
│  │  │  ├─ FilterGenerator.php
│  │  │  ├─ MigrationGenerator.php
│  │  │  ├─ ModelGenerator.php
│  │  │  ├─ ScaffoldGenerator.php
│  │  │  ├─ SeederGenerator.php
│  │  │  ├─ TestGenerator.php
│  │  │  ├─ ValidationGenerator.php
│  │  │  └─ Views
│  │  │     ├─ cell.tpl.php
│  │  │     ├─ cell_view.tpl.php
│  │  │     ├─ command.tpl.php
│  │  │     ├─ config.tpl.php
│  │  │     ├─ controller.tpl.php
│  │  │     ├─ entity.tpl.php
│  │  │     ├─ filter.tpl.php
│  │  │     ├─ migration.tpl.php
│  │  │     ├─ model.tpl.php
│  │  │     ├─ seeder.tpl.php
│  │  │     ├─ test.tpl.php
│  │  │     └─ validation.tpl.php
│  │  ├─ Help.php
│  │  ├─ Housekeeping
│  │  │  ├─ ClearDebugbar.php
│  │  │  └─ ClearLogs.php
│  │  ├─ ListCommands.php
│  │  ├─ Server
│  │  │  └─ Serve.php
│  │  ├─ Translation
│  │  │  ├─ LocalizationFinder.php
│  │  │  └─ LocalizationSync.php
│  │  └─ Utilities
│  │     ├─ ConfigCheck.php
│  │     ├─ Environment.php
│  │     ├─ FilterCheck.php
│  │     ├─ Namespaces.php
│  │     ├─ Optimize.php
│  │     ├─ PhpIniCheck.php
│  │     ├─ Publish.php
│  │     ├─ Routes
│  │     │  ├─ AutoRouteCollector.php
│  │     │  ├─ AutoRouterImproved
│  │     │  │  ├─ AutoRouteCollector.php
│  │     │  │  └─ ControllerMethodReader.php
│  │     │  ├─ ControllerFinder.php
│  │     │  ├─ ControllerMethodReader.php
│  │     │  ├─ FilterCollector.php
│  │     │  ├─ FilterFinder.php
│  │     │  └─ SampleURIGenerator.php
│  │     └─ Routes.php
│  ├─ Common.php
│  ├─ ComposerScripts.php
│  ├─ Config
│  │  ├─ AutoloadConfig.php
│  │  ├─ BaseConfig.php
│  │  ├─ BaseService.php
│  │  ├─ DotEnv.php
│  │  ├─ Factories.php
│  │  ├─ Factory.php
│  │  ├─ Filters.php
│  │  ├─ ForeignCharacters.php
│  │  ├─ Publisher.php
│  │  ├─ Routing.php
│  │  ├─ Services.php
│  │  └─ View.php
│  ├─ Controller.php
│  ├─ Cookie
│  │  ├─ CloneableCookieInterface.php
│  │  ├─ Cookie.php
│  │  ├─ CookieInterface.php
│  │  ├─ CookieStore.php
│  │  └─ Exceptions
│  │     └─ CookieException.php
│  ├─ Database
│  │  ├─ BaseBuilder.php
│  │  ├─ BaseConnection.php
│  │  ├─ BasePreparedQuery.php
│  │  ├─ BaseResult.php
│  │  ├─ BaseUtils.php
│  │  ├─ Config.php
│  │  ├─ ConnectionInterface.php
│  │  ├─ Database.php
│  │  ├─ Exceptions
│  │  │  ├─ DatabaseException.php
│  │  │  ├─ DataException.php
│  │  │  └─ ExceptionInterface.php
│  │  ├─ Forge.php
│  │  ├─ Migration.php
│  │  ├─ MigrationRunner.php
│  │  ├─ MySQLi
│  │  │  ├─ Builder.php
│  │  │  ├─ Connection.php
│  │  │  ├─ Forge.php
│  │  │  ├─ PreparedQuery.php
│  │  │  ├─ Result.php
│  │  │  └─ Utils.php
│  │  ├─ OCI8
│  │  │  ├─ Builder.php
│  │  │  ├─ Connection.php
│  │  │  ├─ Forge.php
│  │  │  ├─ PreparedQuery.php
│  │  │  ├─ Result.php
│  │  │  └─ Utils.php
│  │  ├─ Postgre
│  │  │  ├─ Builder.php
│  │  │  ├─ Connection.php
│  │  │  ├─ Forge.php
│  │  │  ├─ PreparedQuery.php
│  │  │  ├─ Result.php
│  │  │  └─ Utils.php
│  │  ├─ PreparedQueryInterface.php
│  │  ├─ Query.php
│  │  ├─ QueryInterface.php
│  │  ├─ RawSql.php
│  │  ├─ ResultInterface.php
│  │  ├─ Seeder.php
│  │  ├─ SQLite3
│  │  │  ├─ Builder.php
│  │  │  ├─ Connection.php
│  │  │  ├─ Forge.php
│  │  │  ├─ PreparedQuery.php
│  │  │  ├─ Result.php
│  │  │  ├─ Table.php
│  │  │  └─ Utils.php
│  │  ├─ SQLSRV
│  │  │  ├─ Builder.php
│  │  │  ├─ Connection.php
│  │  │  ├─ Forge.php
│  │  │  ├─ PreparedQuery.php
│  │  │  ├─ Result.php
│  │  │  └─ Utils.php
│  │  └─ TableName.php
│  ├─ DataCaster
│  │  ├─ Cast
│  │  │  ├─ ArrayCast.php
│  │  │  ├─ BaseCast.php
│  │  │  ├─ BooleanCast.php
│  │  │  ├─ CastInterface.php
│  │  │  ├─ CSVCast.php
│  │  │  ├─ DatetimeCast.php
│  │  │  ├─ FloatCast.php
│  │  │  ├─ IntBoolCast.php
│  │  │  ├─ IntegerCast.php
│  │  │  ├─ JsonCast.php
│  │  │  ├─ TimestampCast.php
│  │  │  └─ URICast.php
│  │  ├─ DataCaster.php
│  │  └─ Exceptions
│  │     └─ CastException.php
│  ├─ DataConverter
│  │  └─ DataConverter.php
│  ├─ Debug
│  │  ├─ BaseExceptionHandler.php
│  │  ├─ ExceptionHandler.php
│  │  ├─ ExceptionHandlerInterface.php
│  │  ├─ Exceptions.php
│  │  ├─ Iterator.php
│  │  ├─ Timer.php
│  │  ├─ Toolbar
│  │  │  ├─ Collectors
│  │  │  │  ├─ BaseCollector.php
│  │  │  │  ├─ Config.php
│  │  │  │  ├─ Database.php
│  │  │  │  ├─ Events.php
│  │  │  │  ├─ Files.php
│  │  │  │  ├─ History.php
│  │  │  │  ├─ Logs.php
│  │  │  │  ├─ Routes.php
│  │  │  │  ├─ Timers.php
│  │  │  │  └─ Views.php
│  │  │  └─ Views
│  │  │     ├─ toolbar.css
│  │  │     ├─ toolbar.js
│  │  │     ├─ toolbar.tpl.php
│  │  │     ├─ toolbarloader.js
│  │  │     ├─ _config.tpl
│  │  │     ├─ _database.tpl
│  │  │     ├─ _events.tpl
│  │  │     ├─ _files.tpl
│  │  │     ├─ _history.tpl
│  │  │     ├─ _logs.tpl
│  │  │     └─ _routes.tpl
│  │  └─ Toolbar.php
│  ├─ Email
│  │  └─ Email.php
│  ├─ Encryption
│  │  ├─ EncrypterInterface.php
│  │  ├─ Encryption.php
│  │  ├─ Exceptions
│  │  │  └─ EncryptionException.php
│  │  └─ Handlers
│  │     ├─ BaseHandler.php
│  │     ├─ OpenSSLHandler.php
│  │     └─ SodiumHandler.php
│  ├─ Entity
│  │  ├─ Cast
│  │  │  ├─ ArrayCast.php
│  │  │  ├─ BaseCast.php
│  │  │  ├─ BooleanCast.php
│  │  │  ├─ CastInterface.php
│  │  │  ├─ CSVCast.php
│  │  │  ├─ DatetimeCast.php
│  │  │  ├─ FloatCast.php
│  │  │  ├─ IntBoolCast.php
│  │  │  ├─ IntegerCast.php
│  │  │  ├─ JsonCast.php
│  │  │  ├─ ObjectCast.php
│  │  │  ├─ StringCast.php
│  │  │  ├─ TimestampCast.php
│  │  │  └─ URICast.php
│  │  ├─ Entity.php
│  │  └─ Exceptions
│  │     └─ CastException.php
│  ├─ Events
│  │  └─ Events.php
│  ├─ Exceptions
│  │  ├─ BadFunctionCallException.php
│  │  ├─ BadMethodCallException.php
│  │  ├─ ConfigException.php
│  │  ├─ CriticalError.php
│  │  ├─ DebugTraceableTrait.php
│  │  ├─ DownloadException.php
│  │  ├─ ExceptionInterface.php
│  │  ├─ FrameworkException.php
│  │  ├─ HasExitCodeInterface.php
│  │  ├─ HTTPExceptionInterface.php
│  │  ├─ InvalidArgumentException.php
│  │  ├─ LogicException.php
│  │  ├─ ModelException.php
│  │  ├─ PageNotFoundException.php
│  │  ├─ RuntimeException.php
│  │  └─ TestException.php
│  ├─ Files
│  │  ├─ Exceptions
│  │  │  ├─ ExceptionInterface.php
│  │  │  ├─ FileException.php
│  │  │  └─ FileNotFoundException.php
│  │  ├─ File.php
│  │  ├─ FileCollection.php
│  │  └─ FileSizeUnit.php
│  ├─ Filters
│  │  ├─ Cors.php
│  │  ├─ CSRF.php
│  │  ├─ DebugToolbar.php
│  │  ├─ Exceptions
│  │  │  └─ FilterException.php
│  │  ├─ FilterInterface.php
│  │  ├─ Filters.php
│  │  ├─ ForceHTTPS.php
│  │  ├─ Honeypot.php
│  │  ├─ InvalidChars.php
│  │  ├─ PageCache.php
│  │  ├─ PerformanceMetrics.php
│  │  └─ SecureHeaders.php
│  ├─ Format
│  │  ├─ Exceptions
│  │  │  └─ FormatException.php
│  │  ├─ Format.php
│  │  ├─ FormatterInterface.php
│  │  ├─ JSONFormatter.php
│  │  └─ XMLFormatter.php
│  ├─ Helpers
│  │  ├─ Array
│  │  │  └─ ArrayHelper.php
│  │  ├─ array_helper.php
│  │  ├─ cookie_helper.php
│  │  ├─ date_helper.php
│  │  ├─ filesystem_helper.php
│  │  ├─ form_helper.php
│  │  ├─ html_helper.php
│  │  ├─ inflector_helper.php
│  │  ├─ kint_helper.php
│  │  ├─ number_helper.php
│  │  ├─ security_helper.php
│  │  ├─ test_helper.php
│  │  ├─ text_helper.php
│  │  ├─ url_helper.php
│  │  └─ xml_helper.php
│  ├─ Honeypot
│  │  ├─ Exceptions
│  │  │  └─ HoneypotException.php
│  │  └─ Honeypot.php
│  ├─ HotReloader
│  │  ├─ DirectoryHasher.php
│  │  ├─ HotReloader.php
│  │  └─ IteratorFilter.php
│  ├─ HTTP
│  │  ├─ CLIRequest.php
│  │  ├─ ContentSecurityPolicy.php
│  │  ├─ Cors.php
│  │  ├─ CURLRequest.php
│  │  ├─ DownloadResponse.php
│  │  ├─ Exceptions
│  │  │  ├─ BadRequestException.php
│  │  │  ├─ ExceptionInterface.php
│  │  │  ├─ HTTPException.php
│  │  │  └─ RedirectException.php
│  │  ├─ Files
│  │  │  ├─ FileCollection.php
│  │  │  ├─ UploadedFile.php
│  │  │  └─ UploadedFileInterface.php
│  │  ├─ Header.php
│  │  ├─ IncomingRequest.php
│  │  ├─ Message.php
│  │  ├─ MessageInterface.php
│  │  ├─ MessageTrait.php
│  │  ├─ Method.php
│  │  ├─ Negotiate.php
│  │  ├─ OutgoingRequest.php
│  │  ├─ OutgoingRequestInterface.php
│  │  ├─ RedirectResponse.php
│  │  ├─ Request.php
│  │  ├─ RequestInterface.php
│  │  ├─ RequestTrait.php
│  │  ├─ ResponsableInterface.php
│  │  ├─ Response.php
│  │  ├─ ResponseInterface.php
│  │  ├─ ResponseTrait.php
│  │  ├─ SiteURI.php
│  │  ├─ SiteURIFactory.php
│  │  ├─ URI.php
│  │  └─ UserAgent.php
│  ├─ I18n
│  │  ├─ Exceptions
│  │  │  └─ I18nException.php
│  │  ├─ Time.php
│  │  ├─ TimeDifference.php
│  │  ├─ TimeLegacy.php
│  │  └─ TimeTrait.php
│  ├─ Images
│  │  ├─ Exceptions
│  │  │  └─ ImageException.php
│  │  ├─ Handlers
│  │  │  ├─ BaseHandler.php
│  │  │  ├─ GDHandler.php
│  │  │  └─ ImageMagickHandler.php
│  │  ├─ Image.php
│  │  └─ ImageHandlerInterface.php
│  ├─ index.html
│  ├─ Language
│  │  ├─ en
│  │  │  ├─ Cache.php
│  │  │  ├─ Cast.php
│  │  │  ├─ CLI.php
│  │  │  ├─ Cookie.php
│  │  │  ├─ Core.php
│  │  │  ├─ Database.php
│  │  │  ├─ Email.php
│  │  │  ├─ Encryption.php
│  │  │  ├─ Errors.php
│  │  │  ├─ Fabricator.php
│  │  │  ├─ Files.php
│  │  │  ├─ Filters.php
│  │  │  ├─ Format.php
│  │  │  ├─ HTTP.php
│  │  │  ├─ Images.php
│  │  │  ├─ Language.php
│  │  │  ├─ Log.php
│  │  │  ├─ Migrations.php
│  │  │  ├─ Number.php
│  │  │  ├─ Pager.php
│  │  │  ├─ Publisher.php
│  │  │  ├─ RESTful.php
│  │  │  ├─ Router.php
│  │  │  ├─ Security.php
│  │  │  ├─ Session.php
│  │  │  ├─ Test.php
│  │  │  ├─ Time.php
│  │  │  ├─ Validation.php
│  │  │  └─ View.php
│  │  └─ Language.php
│  ├─ Log
│  │  ├─ Exceptions
│  │  │  └─ LogException.php
│  │  ├─ Handlers
│  │  │  ├─ BaseHandler.php
│  │  │  ├─ ChromeLoggerHandler.php
│  │  │  ├─ ErrorlogHandler.php
│  │  │  ├─ FileHandler.php
│  │  │  └─ HandlerInterface.php
│  │  └─ Logger.php
│  ├─ Model.php
│  ├─ Modules
│  │  └─ Modules.php
│  ├─ Pager
│  │  ├─ Exceptions
│  │  │  └─ PagerException.php
│  │  ├─ Pager.php
│  │  ├─ PagerInterface.php
│  │  ├─ PagerRenderer.php
│  │  └─ Views
│  │     ├─ default_full.php
│  │     ├─ default_head.php
│  │     └─ default_simple.php
│  ├─ Publisher
│  │  ├─ ContentReplacer.php
│  │  ├─ Exceptions
│  │  │  └─ PublisherException.php
│  │  └─ Publisher.php
│  ├─ RESTful
│  │  ├─ BaseResource.php
│  │  ├─ ResourceController.php
│  │  └─ ResourcePresenter.php
│  ├─ rewrite.php
│  ├─ Router
│  │  ├─ AutoRouter.php
│  │  ├─ AutoRouterImproved.php
│  │  ├─ AutoRouterInterface.php
│  │  ├─ DefinedRouteCollector.php
│  │  ├─ Exceptions
│  │  │  ├─ ExceptionInterface.php
│  │  │  ├─ MethodNotFoundException.php
│  │  │  └─ RouterException.php
│  │  ├─ RouteCollection.php
│  │  ├─ RouteCollectionInterface.php
│  │  ├─ Router.php
│  │  └─ RouterInterface.php
│  ├─ Security
│  │  ├─ CheckPhpIni.php
│  │  ├─ Exceptions
│  │  │  └─ SecurityException.php
│  │  ├─ Security.php
│  │  └─ SecurityInterface.php
│  ├─ Session
│  │  ├─ Exceptions
│  │  │  └─ SessionException.php
│  │  ├─ Handlers
│  │  │  ├─ ArrayHandler.php
│  │  │  ├─ BaseHandler.php
│  │  │  ├─ Database
│  │  │  │  ├─ MySQLiHandler.php
│  │  │  │  └─ PostgreHandler.php
│  │  │  ├─ DatabaseHandler.php
│  │  │  ├─ FileHandler.php
│  │  │  ├─ MemcachedHandler.php
│  │  │  └─ RedisHandler.php
│  │  ├─ Session.php
│  │  └─ SessionInterface.php
│  ├─ Superglobals.php
│  ├─ Test
│  │  ├─ bootstrap.php
│  │  ├─ CIUnitTestCase.php
│  │  ├─ ConfigFromArrayTrait.php
│  │  ├─ Constraints
│  │  │  └─ SeeInDatabase.php
│  │  ├─ ControllerTestTrait.php
│  │  ├─ DatabaseTestTrait.php
│  │  ├─ DOMParser.php
│  │  ├─ Fabricator.php
│  │  ├─ FeatureTestTrait.php
│  │  ├─ Filters
│  │  │  └─ CITestStreamFilter.php
│  │  ├─ FilterTestTrait.php
│  │  ├─ IniTestTrait.php
│  │  ├─ Interfaces
│  │  │  └─ FabricatorModel.php
│  │  ├─ Mock
│  │  │  ├─ MockAppConfig.php
│  │  │  ├─ MockAutoload.php
│  │  │  ├─ MockBuilder.php
│  │  │  ├─ MockCache.php
│  │  │  ├─ MockCLIConfig.php
│  │  │  ├─ MockCodeIgniter.php
│  │  │  ├─ MockCommon.php
│  │  │  ├─ MockConnection.php
│  │  │  ├─ MockCURLRequest.php
│  │  │  ├─ MockEmail.php
│  │  │  ├─ MockEvents.php
│  │  │  ├─ MockFileLogger.php
│  │  │  ├─ MockIncomingRequest.php
│  │  │  ├─ MockInputOutput.php
│  │  │  ├─ MockLanguage.php
│  │  │  ├─ MockLogger.php
│  │  │  ├─ MockQuery.php
│  │  │  ├─ MockResourceController.php
│  │  │  ├─ MockResourcePresenter.php
│  │  │  ├─ MockResponse.php
│  │  │  ├─ MockResult.php
│  │  │  ├─ MockSecurity.php
│  │  │  ├─ MockServices.php
│  │  │  ├─ MockSession.php
│  │  │  └─ MockTable.php
│  │  ├─ PhpStreamWrapper.php
│  │  ├─ ReflectionHelper.php
│  │  ├─ StreamFilterTrait.php
│  │  ├─ TestLogger.php
│  │  └─ TestResponse.php
│  ├─ ThirdParty
│  │  ├─ Escaper
│  │  │  ├─ Escaper.php
│  │  │  ├─ EscaperInterface.php
│  │  │  ├─ Exception
│  │  │  │  ├─ ExceptionInterface.php
│  │  │  │  ├─ InvalidArgumentException.php
│  │  │  │  └─ RuntimeException.php
│  │  │  └─ LICENSE.md
│  │  ├─ Kint
│  │  │  ├─ CallFinder.php
│  │  │  ├─ FacadeInterface.php
│  │  │  ├─ init.php
│  │  │  ├─ init_helpers.php
│  │  │  ├─ Kint.php
│  │  │  ├─ LICENSE
│  │  │  ├─ Parser
│  │  │  │  ├─ AbstractPlugin.php
│  │  │  │  ├─ ArrayLimitPlugin.php
│  │  │  │  ├─ ArrayObjectPlugin.php
│  │  │  │  ├─ Base64Plugin.php
│  │  │  │  ├─ BinaryPlugin.php
│  │  │  │  ├─ BlacklistPlugin.php
│  │  │  │  ├─ ClassHooksPlugin.php
│  │  │  │  ├─ ClassMethodsPlugin.php
│  │  │  │  ├─ ClassStaticsPlugin.php
│  │  │  │  ├─ ClassStringsPlugin.php
│  │  │  │  ├─ ClosurePlugin.php
│  │  │  │  ├─ ColorPlugin.php
│  │  │  │  ├─ ConstructablePluginInterface.php
│  │  │  │  ├─ DateTimePlugin.php
│  │  │  │  ├─ DomPlugin.php
│  │  │  │  ├─ EnumPlugin.php
│  │  │  │  ├─ FsPathPlugin.php
│  │  │  │  ├─ HtmlPlugin.php
│  │  │  │  ├─ IteratorPlugin.php
│  │  │  │  ├─ JsonPlugin.php
│  │  │  │  ├─ MicrotimePlugin.php
│  │  │  │  ├─ MysqliPlugin.php
│  │  │  │  ├─ Parser.php
│  │  │  │  ├─ PluginBeginInterface.php
│  │  │  │  ├─ PluginCompleteInterface.php
│  │  │  │  ├─ PluginInterface.php
│  │  │  │  ├─ ProfilePlugin.php
│  │  │  │  ├─ ProxyPlugin.php
│  │  │  │  ├─ SerializePlugin.php
│  │  │  │  ├─ SimpleXMLElementPlugin.php
│  │  │  │  ├─ SplFileInfoPlugin.php
│  │  │  │  ├─ StreamPlugin.php
│  │  │  │  ├─ TablePlugin.php
│  │  │  │  ├─ ThrowablePlugin.php
│  │  │  │  ├─ TimestampPlugin.php
│  │  │  │  ├─ ToStringPlugin.php
│  │  │  │  ├─ TracePlugin.php
│  │  │  │  └─ XmlPlugin.php
│  │  │  ├─ Renderer
│  │  │  │  ├─ AbstractRenderer.php
│  │  │  │  ├─ AssetRendererTrait.php
│  │  │  │  ├─ CliRenderer.php
│  │  │  │  ├─ ConstructableRendererInterface.php
│  │  │  │  ├─ PlainRenderer.php
│  │  │  │  ├─ RendererInterface.php
│  │  │  │  ├─ Rich
│  │  │  │  │  ├─ AbstractPlugin.php
│  │  │  │  │  ├─ BinaryPlugin.php
│  │  │  │  │  ├─ CallableDefinitionPlugin.php
│  │  │  │  │  ├─ CallablePlugin.php
│  │  │  │  │  ├─ ColorPlugin.php
│  │  │  │  │  ├─ LockPlugin.php
│  │  │  │  │  ├─ MicrotimePlugin.php
│  │  │  │  │  ├─ PluginInterface.php
│  │  │  │  │  ├─ ProfilePlugin.php
│  │  │  │  │  ├─ SourcePlugin.php
│  │  │  │  │  ├─ TablePlugin.php
│  │  │  │  │  ├─ TabPluginInterface.php
│  │  │  │  │  ├─ TraceFramePlugin.php
│  │  │  │  │  └─ ValuePluginInterface.php
│  │  │  │  ├─ RichRenderer.php
│  │  │  │  ├─ Text
│  │  │  │  │  ├─ AbstractPlugin.php
│  │  │  │  │  ├─ LockPlugin.php
│  │  │  │  │  ├─ MicrotimePlugin.php
│  │  │  │  │  ├─ PluginInterface.php
│  │  │  │  │  ├─ SplFileInfoPlugin.php
│  │  │  │  │  └─ TracePlugin.php
│  │  │  │  └─ TextRenderer.php
│  │  │  ├─ resources
│  │  │  │  └─ compiled
│  │  │  │     ├─ aante-dark.css
│  │  │  │     ├─ aante-light.css
│  │  │  │     ├─ main.js
│  │  │  │     ├─ original.css
│  │  │  │     ├─ plain.css
│  │  │  │     ├─ solarized-dark.css
│  │  │  │     └─ solarized.css
│  │  │  ├─ Utils.php
│  │  │  └─ Value
│  │  │     ├─ AbstractValue.php
│  │  │     ├─ ArrayValue.php
│  │  │     ├─ ClosedResourceValue.php
│  │  │     ├─ ClosureValue.php
│  │  │     ├─ ColorValue.php
│  │  │     ├─ Context
│  │  │     │  ├─ ArrayContext.php
│  │  │     │  ├─ BaseContext.php
│  │  │     │  ├─ ClassConstContext.php
│  │  │     │  ├─ ClassDeclaredContext.php
│  │  │     │  ├─ ClassOwnedContext.php
│  │  │     │  ├─ ContextInterface.php
│  │  │     │  ├─ DoubleAccessMemberContext.php
│  │  │     │  ├─ MethodContext.php
│  │  │     │  ├─ PropertyContext.php
│  │  │     │  └─ StaticPropertyContext.php
│  │  │     ├─ DateTimeValue.php
│  │  │     ├─ DeclaredCallableBag.php
│  │  │     ├─ DomNodeListValue.php
│  │  │     ├─ DomNodeValue.php
│  │  │     ├─ EnumValue.php
│  │  │     ├─ FixedWidthValue.php
│  │  │     ├─ FunctionValue.php
│  │  │     ├─ InstanceValue.php
│  │  │     ├─ MethodValue.php
│  │  │     ├─ MicrotimeValue.php
│  │  │     ├─ ParameterBag.php
│  │  │     ├─ ParameterHoldingTrait.php
│  │  │     ├─ Representation
│  │  │     │  ├─ AbstractRepresentation.php
│  │  │     │  ├─ BinaryRepresentation.php
│  │  │     │  ├─ CallableDefinitionRepresentation.php
│  │  │     │  ├─ ColorRepresentation.php
│  │  │     │  ├─ ContainerRepresentation.php
│  │  │     │  ├─ MicrotimeRepresentation.php
│  │  │     │  ├─ ProfileRepresentation.php
│  │  │     │  ├─ RepresentationInterface.php
│  │  │     │  ├─ SourceRepresentation.php
│  │  │     │  ├─ SplFileInfoRepresentation.php
│  │  │     │  ├─ StringRepresentation.php
│  │  │     │  ├─ TableRepresentation.php
│  │  │     │  └─ ValueRepresentation.php
│  │  │     ├─ ResourceValue.php
│  │  │     ├─ SimpleXMLElementValue.php
│  │  │     ├─ SplFileInfoValue.php
│  │  │     ├─ StreamValue.php
│  │  │     ├─ StringValue.php
│  │  │     ├─ ThrowableValue.php
│  │  │     ├─ TraceFrameValue.php
│  │  │     ├─ TraceValue.php
│  │  │     ├─ UninitializedValue.php
│  │  │     ├─ UnknownValue.php
│  │  │     └─ VirtualValue.php
│  │  └─ PSR
│  │     └─ Log
│  │        ├─ AbstractLogger.php
│  │        ├─ InvalidArgumentException.php
│  │        ├─ LICENSE
│  │        ├─ LoggerAwareInterface.php
│  │        ├─ LoggerAwareTrait.php
│  │        ├─ LoggerInterface.php
│  │        ├─ LoggerTrait.php
│  │        ├─ LogLevel.php
│  │        └─ NullLogger.php
│  ├─ Throttle
│  │  ├─ Throttler.php
│  │  └─ ThrottlerInterface.php
│  ├─ Traits
│  │  ├─ ConditionalTrait.php
│  │  └─ PropertiesTrait.php
│  ├─ Typography
│  │  └─ Typography.php
│  ├─ util_bootstrap.php
│  ├─ Validation
│  │  ├─ CreditCardRules.php
│  │  ├─ DotArrayFilter.php
│  │  ├─ Exceptions
│  │  │  └─ ValidationException.php
│  │  ├─ FileRules.php
│  │  ├─ FormatRules.php
│  │  ├─ Rules.php
│  │  ├─ StrictRules
│  │  │  ├─ CreditCardRules.php
│  │  │  ├─ FileRules.php
│  │  │  ├─ FormatRules.php
│  │  │  └─ Rules.php
│  │  ├─ Validation.php
│  │  ├─ ValidationInterface.php
│  │  └─ Views
│  │     ├─ list.php
│  │     └─ single.php
│  └─ View
│     ├─ Cell.php
│     ├─ Cells
│     │  └─ Cell.php
│     ├─ Exceptions
│     │  └─ ViewException.php
│     ├─ Filters.php
│     ├─ Parser.php
│     ├─ Plugins.php
│     ├─ RendererInterface.php
│     ├─ Table.php
│     ├─ View.php
│     ├─ ViewDecoratorInterface.php
│     └─ ViewDecoratorTrait.php
├─ tests
│  ├─ .htaccess
│  ├─ database
│  │  └─ ExampleDatabaseTest.php
│  ├─ index.html
│  ├─ README.md
│  ├─ session
│  │  └─ ExampleSessionTest.php
│  ├─ unit
│  │  └─ HealthTest.php
│  └─ _support
│     ├─ Database
│     │  ├─ Migrations
│     │  │  └─ 2020-02-22-222222_example_migration.php
│     │  └─ Seeds
│     │     └─ ExampleSeeder.php
│     ├─ Libraries
│     │  └─ ConfigReader.php
│     └─ Models
│        └─ ExampleModel.php
└─ writable
   ├─ .htaccess
   ├─ cache
   │  └─ index.html
   ├─ debugbar
   │  └─ index.html
   ├─ index.html
   ├─ logs
   │  └─ index.html
   ├─ session
   │  └─ index.html
   └─ uploads
      └─ index.html

```