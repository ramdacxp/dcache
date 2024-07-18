# dcache

**dcache** is a PHP REST API implementing a JSON data cache.

* The data cache consists of _data sets_ containing multiple _properties_ as key-value-pairs.
* A _data set_ is identified by an unique _token_.
* _Data Provider_ can create, update, and remove _data sets_.
* _Consumer_ can query a _data set_ identified by the provided _token_.

A running demo is available at: <https://dcache.schademarmelade.de/>.

![dcache Table View](doc/tableview.png)

Usage examples:

* Selected [Home Assistant](https:c//www.home-assistant.io/) entities can be pushed to **dcache** and visualized on a [TRMNL](https://usetrmnl.com/) e-ink display via a [custom TRMNL-Plugin](https://help.usetrmnl.com/en/articles/9510536-custom-plugins).
* The result status of a DevOps build pipeline can be sent to **dcache** and visualized on a WLED led strip.
* The battery status of multiple IoT devices is available in a single **dcache** data set.
* ...

A typical data flow between Home Assistant, **dcache**, and TRMNL could look like this:

* HA provides `temperature=25`
* HA provides `humidity=65`
* TRMNL receives `{ temperature=25, humidity=65 }`
* HA provides `fan=on`
* HA provides `humidity=40`
* TRMNL receives `{ temperature=25, humidity=40, fan=on }`

## Server Setup

Simply upload the `www` folder to your PHP enabled webserver and open the related address in a browser to setup your database connection.

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

All tools and test data can be removed completely by deleting the `bin` and `node_modules` sub-folders.

## Run dcache locally

* Execute `npm start` or choose `Terminal > Run Build Task...` in VSCode.
* Open the local dev webserver address <http://localhost:8080/> in your browser.
* Stop the servers by pressing `Ctrl-C` in the Terminal window.

## Settings

If the settings file `src/settings.php` is missing, a settings form is shown on the website to interactively configure the database connection.
Simply accept the default values if using the development servers.
Once configured, the form is no longer available. To revert the configuration, the settings file `src/settings.php` needs to be removed.

The default `src/settings.php` will have the following content:

```php
<?php
$settings = [];
$settings["database"] = "mysql:host=localhost;dbname=dcache";
$settings["user"] = "root";
$settings["password"] = "";
$settings["prefix"] = "dc-";
```

## API Details

The REST API is exposed at `/api.php`.

For a list of supported requests and related responses, please refer to the [`requests.http`](./requests.http) sample file.
All requests can be executed against the provided PHP development webserver in order to test and debug the API.
This requires VSCode with the [REST Client](https://marketplace.visualstudio.com/items?itemName=humao.rest-client) extension installed.

| Method | URL                                         | Description                               | Success Response                      |
|--------|---------------------------------------------|-------------------------------------------|---------------------------------------|
| GET    | `/api.php?token=T`                          | Query complete dataset `T`                | Dataset `T` as object `{...}`         |
| GET    | `/api.php?token=T&property=P`               | Query property `P` from dataset `T`       | Value of `P` as string `"val"`        |
| GET²   | `/api.php?token=T&property=P&value=V`       | Update property `P` to `V` in dataset `T` | Updated dataset `T` as object `{...}` |
| POST   | `/api.php?token=T`                          | Update provided properties in dataset `T` | Updated dataset `T` as object `{...}` |
| DELETE | `/api.php?token=T`                          | Remove complete dataset `T`               | Boolean `true`                        |
| DELETE | `/api.php?token=T&property=P`               | Remove property `P` from dataset `T`      | Boolean `true`                        |
| GET³   | `/api.php?method=delete&token=T`            | Remove complete dataset `T`               | Boolean `true`                        |
| GET³   | `/api.php?method=delete&token=T&property=P` | Remove property `P` from dataset `T`      | Boolean `true`                        |

Additional `GET` methods as available to use the complete REST API from a regular web browser:  
² - This `GET` method behaves like a `POST` of the single property `P`.  
³ - With the parameter `method=delete` the `DELETE` requests can be invoked via `GET`.

### Restrictions

| Type              | Length   | Characters                    |
|-------------------|----------|-------------------------------|
| Dataset token `T` | min. `8` | `a-z`, `A-Z`, `0-9`, `-`, `.` |
| Property name `P` | min. `1` | `a-z`, `0-9`, `-`, `.`        |

### Request Body (POST)

A `POST` request can be used to update one or more properties of an existing dataset, which is identified by the given token `T`. If the token `T` was not found, a new dataset related to this token is created. The `POST` payload needs to contain the a JSON object in `Content-Type: application/json`.

Example:

If the given dataset, which is related to token `testdata`:

```json
{
  "firstname": "Max",
  "lastname": "Mustermann"
}
```

is updated via `POST /api.php?token=testdata` containing the `Content-Type: application/json` payload:

```json
{
  "firstname": "Hans",
  "town": "New York"
}
```

it will return the updated dataset as JSON object as:

```json
{
  "firstname": "Hans",
  "lastname": "Mustermann",
  "town": "New York"
}
```

### Error Response Messages

In case of errors, a HTTP response code different from `200` (OK) is returned together with an JSON object describing the error.

```json
{
  "kind": "error",
  "code": 400,
  "message": "Token contains invalid characters. Only letters, numbers, dots and dashes are allowed."
}
```

Possible errors:

| Code                 | Message                                                                                |
|----------------------|----------------------------------------------------------------------------------------|
| `400` Bad Request    | Content is not valid JSON.                                                             |
| `400` Bad Request    | Invalid content type. Expected application/json.                                       |
| `400` Bad Request    | No token given.                                                                        |
| `400` Bad Request    | Not implemented.                                                                       |
| `400` Bad Request    | Token contains invalid characters. Only letters, numbers, dots and dashes are allowed. |
| `400` Bad Request    | Token is too short. Must be at least 8 characters long.                                |
| `404` Not found      | Dataset not found.                                                                     |
| `404` Not found      | Property not found in dataset.                                                         |
| `500` Internal Error | Not configured.                                                                        |

## License

See [LICENSE](LICENSE).
