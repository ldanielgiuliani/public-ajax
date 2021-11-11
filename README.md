# Front-facing Public Ajax
The goal of this boilerplate is to have an endpoint that handles the front-facing ajax request with basic sanitization and nonce auth.

### TODO 
Update structures, pattern and WP naming conventions

## Development
1. Clone the plugin repository.
2. Create new action class under `includes/Actions`.

**Endpoint**: `/public-ajax/`

### Required Parameters
| Key    | Description                             |
|--------|-----------------------------------------|
| action | Action class name in `includes/Actions` |
| nonce  | Action: `_wpnonce`                      |

```js
let response = await fetch('/public-ajax/?action=Example&nonce=1cb2c8e383');
```

### Action Class Structure


| Functions | Description                                                                          | Return                   |
|-----------|--------------------------------------------------------------------------------------|--------------------------|
| act()     | Action handler. You can process your parameters here                                 | (mixed) `$data`          |
| args()    | Used to define what keys are in the array passed to self::act(). `nonce` is required | (array) `['nonce']`      |
| method()  | Used to define the HTTP method this action uses                                      | (string) `GET` or `POST` |
```php
class Example {
	public static function act( $params ) {
		return $data;
	}

	public static function args() {
		return [ 'nonce' ];
	}

	public static function method() {
		return 'GET';
	}
}
```

### TODO: update structures, pattern and WP naming conventions
