# alexmigf\forma
WordPress Admin simple form API composer package

## Requirements

- PHP >= 7.0
- WordPress >= 4.4

## Usage

Configure the form settings first

```php
$args = [
	'title'       => 'My form title', // form title (default: '')
	'classes'     => '',              // additional CSS form classes (default: '')
	'action'      => '',              // file to process the form data (default: '')
	'method'      => 'post',          // the form request method (default: 'post')
	'ajax'        => false,           // ajax form request handling (default: false)
	'callback'    => null,            // callback function to process the form data (default: null)
	'nonce'       => true,            // nonce validation, if data is handled by this package (default: false)
	'button_text' => 'Send',          // submit button text (default: Send)
];
```

Instantiate the form class by passing an ID and the configuration array

```php
$forma = new Alexmigf\Forma( $id = 'new-form', $args );
```

Add sections to group multiple fields

```php
$forma->add_section( $section_id = 'profile' );
```

Add single field

```php
$field = [
	'type'     => 'text',
	'id'       => 'first_name',
	'label'    => __( 'First name', 'textdomain' ),
	'value'    => '',
	'required' => true,
];
$forma->add_field( $field, $section_id = 'profile' );

/* or */

$forma->add_field( $field ); // fields without section became 'orfan', non grouped
```

Add multiple fields at once

```php
$fields = [
	[
		'type'     => 'text',
		'id'       => 'first_name',
		'label'    => __( 'First name', 'textdomain' ),
		'value'    => '',
		'required' => true,
	],
	[
		'type'     => 'text',
		'id'       => 'last_name',
		'label'    => __( 'Last name', 'textdomain' ),
		'value'    => '',
		'required' => true,
	],
	[
		'type'     => 'text',
		'id'       => 'company',
		'label'    => __( 'Company', 'textdomain' ),
		'value'    => '',
		'required' => false,
	],
	[
		'type'     => 'text',
		'id'       => 'position',
		'label'    => __( 'Position', 'textdomain' ),
		'value'    => '',
		'required' => false,
	],
	[
		'type'     => 'email',
		'id'       => 'email',
		'label'    => __( 'Email', 'textdomain' ),
		'value'    => '',
		'required' => false,
	],
	[
		'type'     => 'tel',
		'id'       => 'phone_number',
		'label'    => __( 'Phone number', 'textdomain' ),
		'value'    => '',
		'required' => false,
	],
];

$forma->add_fields( $fields, 'profile' );
```

Add custom hidden field

```php
$forma->add_hidden_field( $name = 'custom_hidden_field', $value = '1' );
```

Add custom nonce field

```php
$forma->add_nonce_field( $action = 'custom_nonce_action' );
```

Display the form

```php
$forma->render();
```

## Process callback

If a form callback function is provided, the nonce validation is done inside the forma package, which returns the request data to be processed by the callback.

```php
function new_form_process_callback( $request ) {
	// $request contains the data to be processed
	// do your stuff and return bool

	$response = false;
	if ( ! empty( $request ) ) {
		$response = $this->database->insert( $request );
	}
	return $response;
}
```

If you prefer you could handle the data from an AJAX request as well. The principle is the same as the above callback function, you just need to return the processed data instead of a `bool` and it will be sent back to the AJAX function.

AJAX request example:

```js
jQuery( function( $ ) {

	let id = 'new-form';
	$( '#alexmigf/forma/'+id ).on( 'submit', function( e ) {
		let data = $( this ).serialize();
		$.ajax( {
			url: ajaxUrl,
			data: data,
			type: 'POST',
			cache: false,
			success: function( response ) {
				console.log( response );

				// do your stuff here with the response data
			},
			error: function( xhr, status, error ) {
				console.log( error );
			},
		} );
	} );

} );
```

Callback handling example:

```php
function ajax_new_form_process_callback( $request ) {
	// $request contains the data to be processed
	// do your stuff and then return data to the AJAX function

	$response = false;
	if ( ! empty( $request ) ) {
		$response = [];
		foreach ( $request as $value ) {
			$response[] = $this->do_something_func( $value );
		}
	}
	return $response;
}
```

## Supported field types

- hidden
- submit
- checkbox
- tel
- number
- email
- date
- select
- textarea
- url
- text
