# dcache

_**dcache** is a data cache for [TRMNL](https://usetrmnl.com/)._

It receives data from [Home Assistant](https://www.home-assistant.io/) (or other sources) and provides it in a consolidated way to [TRMNL-Plugins](https://help.usetrmnl.com/en/articles/9510536-custom-plugins) (or other targets).

A typical flow could look like this:

* HA provides `temperature=25`
* HA provides `humidity=65`
* TRMNL receives `{ temperature=25, humidity=65 }`
* HA provides `fan=on`
* HA provides `humidity=40`
* TRMNL receives `{ temperature=25, humidity=40, fan=on }`

dcache provides a REST API to send and receive data as well as an user interface to view the current data.
Each connection-pair is identified by an unique user defined token.
Multiple connections are possible in parallel.

## Server Usage

Simply upload the `www` folder to your PHP enabled webserver and open the related address in a browser.

## Development Setup

Local development on Windows requires the following setup:

* Install Git, NodeJs and VSCode.
* Clone the GitHub repo `https://github.com/ramdacxp/dcache` in VSCode.
* Open the created local folder in VSCode and confirm the installation of all recommended extensions.
* Install PHP and MariaDB locally into a `bin` subfolder by executing `npm install`.
* Import database test data via `reset-testdata.cmd`.

The installation can be repeated by executing the related `install-xxx.cmd` batch files.
No system wide settings are modified during the installation.

The database content can be reset to the initial test data with `reset-testdata.cmd`.
Already existing data in dcache tables will be removed!

All tools can be removed safely by deleting the `bin` and `node_modules` sub-folders.

## Run dcache locally

* Execute `npm start` or choose `Terminal > Run Build Task...` in VSCode.
* Open the local dev webserver <http://localhost:8080/> in your browser.
* Stop the servers by pressing `Ctrl-C` in the Terminal window.

## Settings

If the settings file `src/settings.php` is missing, a settings form is shown on the website to interactively configure the database connection.
Simply accept the default values if using the development servers.
Once configured, the form is no longer available. To revert the configuration, the settings file `src/settings.php` needs to be removed.

The default `src/settings.php` will have the following content:

```php
<?php
$settings = [];
$settings["server"] = "localhost";
$settings["user"] = "root";
$settings["password"] = "";
$settings["database"] = "dcache";
$settings["prefix"] = "dc-";
```

## License

See [LICENSE](LICENSE).
