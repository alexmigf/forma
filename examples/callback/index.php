<?php

use Alexmigf\Forma;

class myForm {

	/**
	 * Fake database object property
	 * @var object
	 */
	public $database;

	// your other methods here

	/**
	 * Fake function to display content on a page
	 * @return void
	 */
	public function my_page() {
		$forma = new Forma(
			'add-car',
			[
				'title'    => __( 'Add Car', 'textdomain' ),
				'callback' => [ $this, 'add_car_process_callback' ],
				'nonce'    => true,
			]
		);
		$forma->add_section( 'car_fields' );
		$forma->add_fields( $this->form_fields(), 'car_fields' );
		$forma->render();
	}

	/**
	 * Form callback function
	 * @param mixed $request
	 * @return mixed
	 */
	public function add_car_process_callback( $request ) {
		$response = false;
		if ( ! empty( $request ) ) {
			$response = $this->database->insert( $request );
		}
		return $response;
	}

	/**
	 * Form fields
	 * @return array
	 */
	public function form_fields() {
		return [
			[
				'type'     => 'text',
				'id'       => 'brand',
				'label'    => __( 'Brand', 'textdomain' ),
				'value'    => '',
				'required' => true,
			],
			[
				'type'     => 'text',
				'id'       => 'model',
				'label'    => __( 'Model', 'textdomain' ),
				'value'    => '',
				'required' => true,
			],
			[
				'type'     => 'text',
				'id'       => 'version',
				'label'    => __( 'Version', 'textdomain' ),
				'value'    => '',
				'required' => false,
			],
		];
	}

	// your other methods here

}
