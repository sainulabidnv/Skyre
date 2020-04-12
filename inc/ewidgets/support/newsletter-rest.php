<?php
/**
 * @package     Skyre
 * @author      Skyretheme
 * @copyright   Copyright (c) 2019, Skyre
 * @link        https://skyretheme.com/sports
 * @since       1.0.0
 */

namespace ewidget\Widgets;

/**
 * Class RestServer
 *
 */
class RestServer extends \WP_Rest_Controller {

	/**
	 * @var RestServer
	 */
	public static $instance = null;
	public $success_msg;

	public $namespace = 'rest-forms/';
	public $version = 'v1';
	

	public function init() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$namespace = $this->namespace . $this->version;

		register_rest_route( $namespace, '/submit', array(
			array(
				'methods'  => \WP_REST_Server::READABLE,
				'callback' => array( $this, 'rest_check' )
			),
		) );

		register_rest_route( $namespace, '/submit', array(
			array(
				'methods'             => \WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'submit_form' ),
				'permission_callback' => array( $this, 'submit_forms_permissions_check' ),
				'args'                => array(
					'form_type' => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'What type of form is submitted.', 'skyre' ),
					),
					'nonce'     => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The security key', 'skyre' ),
					),
					'data'      => array(
						'type'        => 'json',
						'required'    => true,
						'description' => __( 'The form must have data', 'skyre' ),
					),
					'form_id'   => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The form identifier.', 'skyre' ),
					),
					'post_id'   => array(
						'type'        => 'string',
						'required'    => true,
						'description' => __( 'The form identifier.', 'skyre' ),
					)
				),
			),
		) );
	}

	public function rest_check( \WP_REST_Request $request ) {
			return rest_ensure_response( 'success' );
	}

	/**
	 * @param \WP_REST_Request $request
	 *
	 * @return mixed|\WP_REST_Response
	 */
	public function submit_form( $request ) {
		$return = array(
			'success' => false,
			'msg'     => esc_html__( 'Something went wrong', 'skyre' )
		);

		$nonce   = $request->get_param( 'nonce' );
		$form_id = $request->get_param( 'form_id' );
		$post_id = $request->get_param( 'post_id' );

		if ( ! wp_verify_nonce( $nonce, 'content-form-' . $form_id ) ) {
			$return['msg'] = 'Invalid nonce';
			return rest_ensure_response( $return );
		}

		$form_type    = $request->get_param( 'form_type' );
		$form_builder = $request->get_param( 'form_builder' );
		$data         = $request->get_param( 'data' );

		if ( empty( $data[ $form_id ] ) ) {
			$return['msg'] = esc_html__( 'Invalid Data ', 'skyre' ) . $form_id;
			return $return;
		}

		$data = $data[ $form_id ];

		/**
		 * Each form type should be able to provide its own process of submitting data.
		 * Must return the success status and a message.
		 */
		$return = $this->rest_submit_form( $return, $data, $form_id, $post_id, $form_builder );
		 

		return rest_ensure_response( $return );
	}

	public function submit_forms_permissions_check() {
		return 1;
	}
	
	public function rest_submit_form( $return, $data, $widget_id, $post_id, $builder ) {

		if ( empty( $data['email'] ) || ! is_email( $data['email'] ) ) {
			$return['msg'] = esc_html__( 'Invalid email.', 'skyre' );

			return $return;
		}

		$email = $data['email'];

		foreach($data as $key=>$value){
			if($key !='email') { 
				$field_args->$key = $value;
			}
		}
		
		// prepare settings for submit
		//$settings = $this->get_widget_settings( $widget_id, $post_id, $builder );
		$el_settings = $this->get_widget_settings( $widget_id, $post_id );
		$settings = $el_settings['settings'];
		

		$provider = 'mailchimp';

		if ( ! empty( $settings['provider'] ) ) {
			$provider = $settings['provider'];
		}
		

		$providerArgs = array();

		if ( empty( $settings['access_key'] ) || empty( $settings['list_id'] ) ) {
			$return['msg'] = esc_html__( 'Wrong email configuration! Please contact administration!', 'skyre' );

			return $return;
		}

		$providerArgs['access_key'] = $settings['access_key'];
		$providerArgs['list_id']    = $settings['list_id'];
		$providerArgs['msg']    	= $settings['succes_message'];

		$return = $this->_subscribe_mail( $return, $field_args, $email, $provider, $providerArgs );

		return $return;
	}
	
	static function get_widget_settings( $widget_id, $post_id ) {

		
		$el_data = \Elementor\Plugin::$instance->db->get_plain_editor( $post_id );
		$el_data = apply_filters( 'elementor/frontend/builder_content_data', $el_data, $post_id );

		if ( ! empty( $el_data ) ) {
			return self::get_widget_data_by_id( $widget_id, $el_data );
		}

		return $el_data;
	}
	
	static function get_widget_data_by_id( $widget_id, $el_data ) {

		if ( ! empty( $el_data ) ) {
			foreach ( $el_data as $el ) {

				if ( $el['elType'] === 'widget' && $el['id'] === $widget_id ) {
					return $el;
				} elseif ( ! empty( $el['elements'] ) ) {
					$el = self::get_widget_data_by_id( $widget_id, $el['elements'] );

					if ( $el ) {
						return $el;
					}
				}
			}
		}

		return false;
	}

	/**
	 * Subscribe the given email to the given provider; either mailchimp or sendinblue.
	 *
	 * @param $result
	 * @param $email
	 * @param string $provider
	 * @param array $provider_args
	 *
	 * @return bool|array
	 */
	private function _subscribe_mail( $result, $field_args = array(), $email, $provider = 'mailchimp', $provider_args = array() ) {

		$api_key = $provider_args['access_key'];
		$list_id = $provider_args['list_id'];
		$success_msg = $provider_args['msg'];

		switch ( $provider ) {

			case 'mailchimp':
				// add a pending subscription for the user to confirm
				// Use 'subscribed' to add an address right away.
    			//Use 'pending' to send a confirmation email.
    			//Use 'unsubscribed' or cleaned to archive unused addresses.

				$status = 'subscribed';
				
				$args = array(
					'method'  => 'PUT',
					'headers' => array(
						'Authorization' => 'Basic ' . base64_encode( 'user:' . $api_key )
					),
					'body'    => json_encode( array(
						'email_address' => $email,
						'status'        => $status, 
						'merge_fields'	=> $field_args
					) )
				);

				
				$url = 'https://' . substr( $api_key, strpos( $api_key, '-' ) + 1 ) . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members/' . md5( strtolower( $email ) ); 

				$response = wp_remote_post( $url, $args );

				if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) ) {
					
					if (is_wp_error( $response )) { 
						$result['msg'] = $response->errors['http_request_failed'][0]; 
						}
					else {
						$body = json_decode( wp_remote_retrieve_body( $response ) );
						$result['msg']    = $body->detail; 
						}
					$result['success'] = false;
					return $result;
				}

				$body = json_decode( wp_remote_retrieve_body( $response ) );
				

				if ( $body->status == $status ) {
					$result['success'] = true;
					$result['msg']     = $success_msg;
				} else {
					$result['success'] = false;
					$result['msg']    = esc_html__( 'Sorry!, somthing went wrong', 'skyre' );
				}

				return $result;
				break;
			case 'sendinblue':

				
				
				$url = 'https://api.sendinblue.com/v3/contacts';
				
				/*$attributes->LASTname =  'Sainul';
				$attributes->FIRSTNAME =  'Abid';
				*/
				$args = array(
					'method'  => 'POST',
					'headers' => array(
						'content-type' => 'application/json',
						'api-key'      => $api_key
					),
					'body'    => json_encode( array(
						'email'            => $email,
						'attributes'       => $field_args,
						'listIds'          => array( (int) $list_id ),
						'emailBlacklisted' => false,
						'smsBlacklisted'   => false,
					) )
				);

				$response = wp_remote_post( $url, $args );

				if ( is_wp_error( $response ) || 201 != wp_remote_retrieve_response_code( $response ) ) {

					$body = json_decode( wp_remote_retrieve_body( $response ), true );
					
					if ( ! empty( $body['message'] ) ) {
						$result['msg'] = $body['message'];
					} else {
						$result['msg'] = $response;
					}

					return $result; 
				}

				$result['success'] = true;
				$result['msg']     = $success_msg;

				return $result;
				break;

			default;
				break;
		}

		return false;
	}

	/**
	 * @static
	 * @since 1.0.0
	 * @access public
	 * @return RestServer
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->init();
		}

		return self::$instance;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'skyre' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'skyre' ), '1.0.0' );
	}
}