# Front-facing Public Ajax
The goal of this boilerplate is to have an endpoint that handles the front-facing ajax request with basic sanitization and nonce auth.

## Development
1. Clone the plugin repository.
2. Create new action class under `php/actions`.

**Endpoint**: `/public-ajax/`

### Required Parameters
| Key    | Description                                                                                                                  |
|--------|------------------------------------------------------------------------------------------------------------------------------|
| action | Format should be in `snake_case` for all requests.                                                                           |
| nonce  | Action name: `_wpnonce` <br> *see [wp_create_nonce()](https://developer.wordpress.org/reference/functions/wp_create_nonce/)* |

```js
let response = await fetch('/public-ajax/?action=example&nonce=1cb2c8e383');
```

### Action Class Structure

Class name will be converted automatically from snake_case format to PascalCase

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
