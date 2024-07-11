# dcache

_**dcache** is a data cache for [TRMNL](https://usetrmnl.com/)._

It receives data from [Home Assistant](https://www.home-assistant.io/) (or other sources) and provides it consolidated to [TRMNL-Plugins](https://help.usetrmnl.com/en/articles/9510536-custom-plugins) (or other targets).

## Development Setup

* Install Git, NodeJs and VSCode.
* Clone the GitHub repo `https://github.com/ramdacxp/dcache` in VSCode.
* Open the created local folder in VSCode and confirm the installation of all recommended extensions.
* Install PHP and MariaDB locally into a `bin` subfolder by executing `npm install`.

The installation can be repeated by executing the related `install-xxx.cmd` batch files. No system wide settings are modified during the installation.

All tools can be removed safely by deleting the `bin` and `node_modules` sub-folders.

## Run it

* Execute `npm start` -or- choose `Terminal > Run Build Task...` in VSCode.
* Open the local dev webserver <http://localhost:8080/> in your browser.
* Stop the servers by pressing `Ctrl-C` in the Terminal window.
