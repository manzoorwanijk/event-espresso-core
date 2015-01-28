<?php if ( ! defined('EVENT_ESPRESSO_VERSION')) { exit('No direct script access allowed'); }
 /**
 *
 * Class EE_Checkout
 *
 * Description
 *
 * @package 			Event Espresso
 * @subpackage    core
 * @author				Brent Christensen
 * @since 				4.5.0
 *
 */
class EE_Checkout {

	/**
	 * 	whether current request originated from the EE admin
	 * @type bool
	 */
	public $admin_request = FALSE;

	/**
	 * whether returning to edit attendee information or to retry a payment
	 * @type bool
	 */
	public $revisit = FALSE;

	/**
	 * whether the primary registrant is returning to edit attendee information or to retry a payment
	 * @type bool
	 */
	public $primary_revisit = FALSE;

	/**
	 * is registration allowed to progress or halted for some reason such as failing to pass recaptcha?
	 * @type bool
	 */
	public $continue_reg = TRUE;

	/**
	 * redirect to thank you page ?
	 * @type bool
	 */
	public $redirect = FALSE;

	/**
	 * generate the reg form or not ?
	 * @type bool
	 */
	public $generate_reg_form = TRUE;

	/**
	 * process a reg form submission or not ?
	 * @type bool
	 */
	public $process_form_submission = FALSE;

	/**
	 * total number of tickets that were in the cart
	 * @type int
	 */
	public $total_ticket_count = 0;

	/**
	 * the reg step slug from the incoming request
	 * @type string
	 */
	public $step = '';

	/**
	 * the reg step slug for a step being edited
	 * @type string
	 */
	public $edit_step = '';

	/**
	 * the action being performed on the current step
	 * @type string
	 */
	public $action = '';

	/**
	 * reg_url_link for a previously saved registration
	 * @type string
	 */
	public $reg_url_link = '';

	/**
	 * string slug for the payment method that was selected during the payment options step
	 * @type string
	 */
	public $selected_method_of_payment = '';

	/**
	 * base url for the site's registration checkout page - additional url params will be added to this
	 * @type string
	 */
	public $reg_page_base_url = '';

	/**
	 * base url for the site's registration cancelled page - additional url params will be added to this
	 * @type string
	 */
	public $cancel_page_url = '';

	/**
	 * base url for the site's thank you page - additional url params will be added to this
	 * @type string
	 */
	public $thank_you_page_url = '';

	/**
	 * base url for any redirects - additional url params will be added to this
	 * @type string
	 */
	public $redirect_url = '';

	/**
	 * form of POST data for use with off-site gateways
	 * @type string
	 */
	public $redirect_form = '';

	/**
	 * array of query where params to use when retrieving cached registrations from $this->checkout->transaction
	 * @type array
	 */
	public $reg_cache_where_params = array();

	/**
	 * a class for managing and creating the JSON encoded array of data that gets passed back to the client during AJAX requests
	 * @type EE_SPCO_JSON_Response
	 */
	public $json_response = NULL;

	/**
	 * where we are going next in the reg process
	 * @type EE_SPCO_Reg_Step
	 */
	public $next_step = NULL;

	/**
	 * where we are in the reg process
	 * @type EE_SPCO_Reg_Step
	 */
	public $current_step = NULL;

	/**
	 * 	$_cart - the current cart object
	 *	@var EE_CART
	 */
	public $cart = NULL;

	/**
	 * 	$_transaction - the current transaction object
	 *	@var EE_Transaction
	 */
	public $transaction = NULL;

	/**
	 * 	the related attendee object for the primary registrant
	 * @type EE_Attendee
	 */
	public $primary_attendee_obj = NULL;

	/**
	 *	$_payment_method - the payment method object for the selected method of payment
	 *	@type EE_Payment_Method
	 */
	public $payment_method = NULL;

	/**
	 * 	if a payment method was selected that uses an on-site gateway, then this is the billing form
	 * @type EE_Billing_Info_Form | EE_Billing_Attendee_Info_Form
	 */
	public $billing_form = NULL;

	/**
	 * 	the entire registration form composed of ALL of the subsections generated by the various reg steps
	 * @type EE_Form_Section_Proper
	 */
	public $registration_form = NULL;

	/**
	 * array of EE_SPCO_Reg_Step objects
	 * @type EE_SPCO_Reg_Step[]
	 */
	public $reg_steps = array();

	/**
	 * array of EE_Payment_Method objects
	 * @type EE_Payment_Method[]
	 */
	public $available_payment_methods = array();



	/**
	 *    class constructor
	 *
	 * @access    public
	 * @return    \EE_Checkout
	 */
	public function __construct(  ) {
		$this->reg_page_base_url = EE_Registry::instance()->CFG->core->reg_page_url();
		$this->thank_you_page_url = EE_Registry::instance()->CFG->core->thank_you_page_url();
		$this->cancel_page_url = EE_Registry::instance()->CFG->core->cancel_page_url();
		$this->continue_reg = apply_filters( 'FHEE__EE_Checkout___construct___continue_reg', TRUE );
		$this->admin_request = is_admin() && ! EE_Registry::instance()->REQ->front_ajax;
		$this->reg_cache_where_params = array( 'order_by' => array( 'REG_count' => 'ASC' ));
	}



	/**
	 *    reset_for_current_request
	 *
	 * @access    public
	 * @return    void
	 */
	public function reset_for_current_request() {
		$this->redirect = FALSE;
		$this->json_response = new EE_SPCO_JSON_Response();
		EE_Form_Section_Proper::reset_js_localization();
	}



	/**
	 *    add_reg_step
	 *
	 * @access    public
	 * @param EE_SPCO_Reg_Step $reg_step_obj
	 * @return    void
	 */
	public function add_reg_step( EE_SPCO_Reg_Step $reg_step_obj ) {
		$this->reg_steps[ $reg_step_obj->slug()  ] = $reg_step_obj;
	}



	/**
	 *    remove_reg_step
	 *
	 * @access    public
	 * @param string $reg_step_slug
	 * @return    void
	 */
	public function remove_reg_step( $reg_step_slug = '' ) {
		unset( $this->reg_steps[ $reg_step_slug  ] );
	}



	/**
	 *    set_reg_step_order
	 *
	 * @access    public
	 * @param string $reg_step_slug
	 * @param int    $order
	 * @return    void
	 */
	public function set_reg_step_order( $reg_step_slug = '', $order = 100 ) {
		if ( isset( $this->reg_steps[ $reg_step_slug  ] )) {
			$this->reg_steps[ $reg_step_slug ]->set_order( $order );
		}
	}



	/**
	 *    set_current_step
	 *
	 * @access    public
	 * @param string $current_step
	 * @return    void
	 */
	public function set_current_step( $current_step ) {
		// grab what step we're on
		$this->current_step = isset( $this->reg_steps[ $current_step ] ) ? $this->reg_steps[ $current_step ] : reset( $this->reg_steps );
		// verify instance
		if ( $this->current_step instanceof EE_SPCO_Reg_Step ) {
			// we don't want to repeat completed steps if this is the first time through SPCO
			if ( $this->current_step->completed() && ! $this->revisit ) {
				// so advance to the next step
				$this->set_next_step();
				// and attempt to set it as the current step
				$this->set_current_step( $this->next_step->slug() );
				return;
			}
			$this->current_step->set_is_current_step( TRUE );
		} else {
			EE_Error::add_error(
				__( 'The current step could not be set.', 'event_espresso' ),
				__FILE__, __FUNCTION__, __LINE__
			);
		}
	}



	/**
	 * 	set_next_step
	 * advances the reg_steps array pointer and sets the next step, then reverses pointer back to the current step
	 *
	 *  @access 	public
	 *  @return 	void
	 */
	public function set_next_step() {
		// set pointer to start of array
		reset( $this->reg_steps );
		// if there is more than one step
		if ( count( $this->reg_steps ) > 1 ) {
			// advance to the current step and set pointer
			while ( key( $this->reg_steps ) != $this->current_step->slug() && key( $this->reg_steps ) != '' ) {
				next( $this->reg_steps );
			}
		}
		// advance one more spot ( if it exists )
		$this->next_step = next( $this->reg_steps );
		// verify instance
		$this->next_step = $this->next_step instanceof EE_SPCO_Reg_Step ? $this->next_step  : NULL;
		// then back to current step to reset
		prev( $this->reg_steps );
	}




	/**
	 * 	get_next_reg_step
	 * 	this simply returns the next step from reg_steps array
	 *
	 *  @access 	public
	 *  @return 	EE_SPCO_Reg_Step
	 */
	public function get_next_reg_step() {
		$next = next( $this->reg_steps );
		prev( $this->reg_steps );
		return $next;
	}



	/**
	 * sort_reg_steps
	 *
	 * @access public
	 * @return void
	 */
	public function sort_reg_steps() {
		$reg_step_sorting_callback = apply_filters( 'FHEE__EE_Checkout__sort_reg_steps__reg_step_sorting_callback', 'reg_step_sorting_callback' );
		uasort( $this->reg_steps, array( $this, $reg_step_sorting_callback ));
	}



	/**
	 * reg_step_sorting_callback
	 *
	 * @access public
	 * @param EE_SPCO_Reg_Step $reg_step_A
	 * @param EE_SPCO_Reg_Step $reg_step_B
	 * @return array()
	 */
	public function reg_step_sorting_callback( EE_SPCO_Reg_Step $reg_step_A, EE_SPCO_Reg_Step $reg_step_B ) {
		// send finalize_registration step to the end of the array
		if ( $reg_step_A->slug() == 'finalize_registration' ) {
			return 1;
		} else if ( $reg_step_B->slug() == 'finalize_registration' ) {
			return -1;
		}
		if ( $reg_step_A->order() == $reg_step_B->order() ) {
			return 0;
		}
		return ( $reg_step_A->order() > $reg_step_B->order() ) ? 1 : -1;
	}



	/**
	 * 	set_reg_step_JSON_info
	 *
	 * 	@access public
	 * 	@return 	void
	 */
	public function set_reg_step_JSON_info() {
		EE_Registry::$i18n_js_strings[ 'reg_steps' ] = array();
		// pass basic reg step data to JS
		foreach ( $this->reg_steps as $reg_step ) {
			EE_Registry::$i18n_js_strings[ 'reg_steps' ][] = $reg_step->slug();
		}
		// reset reg step html
//		$this->json_response->set_reg_step_html( '' );
	}



	/**
	 * 	reset_reg_steps
	 *
	 * 	@access public
	 * 	@return 	bool
	 */
	public function reset_reg_steps() {
		$this->sort_reg_steps();
		$this->set_current_step( EE_Registry::instance()->REQ->get( 'step' ));
		$this->set_next_step();
		// the text that appears on the reg step form submit button
		$this->current_step->set_submit_button_text();
		$this->set_reg_step_JSON_info();
	}


	/**
	 * payment_required
	 * @return boolean
	 */
	public function payment_required() {
		// if NOT:
		//		registration via admin
		//		completed TXN
		//		overpaid TXN
		//		free TXN ( total = 0.00 )
		// then payment required is TRUE
		return ! ( $this->admin_request || $this->transaction->is_completed() || $this->transaction->is_overpaid() || $this->transaction->is_free() ) ? TRUE : FALSE;
	}



	/**
	 * 	initialize_txn_reg_steps_array
	 *
	 * 	@access public
	 * 	@return 	array
	 */
	public function initialize_txn_reg_steps_array() {
		$txn_reg_steps_array = array();
		foreach ( $this->reg_steps as $reg_step ) {
			$txn_reg_steps_array[ $reg_step->slug() ] = FALSE;
		}
		return $txn_reg_steps_array;
	}



	/**
	 * 	update_txn_reg_steps_array
	 *
	 * 	@access public
	 * 	@return 	bool
	 */
	public function update_txn_reg_steps_array() {
		$updated = FALSE;
		/** @type EE_Transaction_Processor $transaction_processor */
		$transaction_processor = EE_Registry::instance()->load_class( 'Transaction_Processor' );
		foreach ( $this->reg_steps as $reg_step ) {
			if ( $reg_step->completed() ) {
				$updated = $transaction_processor->set_reg_step_completed( $this->transaction, $reg_step->slug() ) ? TRUE : $updated;
			}
		}
		if ( $updated ) {
			$this->transaction->save();
		}
		return $updated;
	}



	/**
	 * 	stash_transaction_and_checkout
	 *
	 * 	@access public
	 * 	@return 	bool
	 */
	public function stash_transaction_and_checkout() {
		if ( ! $this->revisit ) {
			$this->update_txn_reg_steps_array();
		}
		// cache the checkout in the session
		EE_Registry::instance()->SSN->set_checkout( $this );
		// save all data to the db, but suppress errors
//		$this->save_all_data( FALSE );
	}




	/**
	 * 	visit_allows_processing_of_this_registration
	 *
	 * 	determines if the current SPCO visit should allow the passed EE_Registration to be used in processing.
	 * 	one of the following conditions must be met:
	 * 		EITHER: 	A) first time thru SPCO -> process ALL registrations ( NOT a revisit )
	 * 		OR : 		B) primary registrant is editing info -> process ALL registrations ( primary_revisit )
	 * 		OR : 		C) another registrant is editing info -> ONLY process their registration ( revisit AND their reg_url_link matches )
	 *
	 * 	@access public
	 * @param 	EE_Registration 	$registration
	 * 	@return 	bool
	 */
	public function visit_allows_processing_of_this_registration( EE_Registration $registration ) {
		return ! $this->revisit || $this->primary_revisit || ( $this->revisit && $this->reg_url_link == $registration->reg_url_link() ) ? TRUE : FALSE;
	}



	/**
	 * 	_transaction_has_primary_registration
	 *
	 * 	@access 		private
	 * 	@return 		bool
	 */
	public function transaction_has_primary_registrant() {
		return $this->primary_attendee_obj instanceof EE_Attendee ? TRUE : FALSE;
	}



	/**
	 *    save_all_data
	 *    simply loops through the current transaction and saves all data for each registration
	 *
	 * @access public
	 * @param bool $show_errors
	 * @return bool
	 */
	public function save_all_data( $show_errors = TRUE ) {
		// verify the transaction
		if ( $this->transaction instanceof EE_Transaction ) {
			// save to ensure that TXN has ID
			$this->transaction->save();
			// grab the saved registrations from the transaction
			foreach ( $this->transaction->registrations( $this->reg_cache_where_params, TRUE ) as $reg_cache_ID => $registration ) {
				$this->_save_registration( $reg_cache_ID, $registration, $show_errors );
			}
		} else {
			if ( $show_errors ) {
				EE_Error::add_error( __( 'A valid Transaction was not found when attempting to save your registration information.', 'event_espresso' ), __FILE__, __FUNCTION__, __LINE__);
			}
			return FALSE;
		}
		return TRUE;
	}


	/**
	 * _save_registration_attendee
	 *
 	 * @param 	string | int 	$reg_cache_ID
	 * @param 	EE_Registration 	$registration
	 * @param bool $show_errors
	 * @return void
	 */
	private function _save_registration( $reg_cache_ID, $registration, $show_errors = TRUE  ) {
		// verify object
		if ( $registration instanceof EE_Registration ) {
			// should this registration be processed during this visit ?
			if ( $this->visit_allows_processing_of_this_registration( $registration ) ) {
				//set TXN ID
				if ( ! $registration->transaction_ID() ) {
					$registration->set_transaction_id( $this->transaction->ID() );
				}
				// verify and save the attendee
				$this->_save_registration_attendee( $registration, $show_errors );
				// save answers to reg form questions
				$this->_save_registration_answers( $registration, $show_errors );
				// save changes
				$registration->save();
				// update txn cache
				if ( ! $this->transaction->update_cache_after_object_save( 'Registration', $registration, $reg_cache_ID )) {
					if ( $show_errors ) {
						EE_Error::add_error( __( 'The newly saved Registration object could not be cached on the Transaction.', 'event_espresso' ), __FILE__, __FUNCTION__, __LINE__);
					}
				}
			}
		} else {
			if ( $show_errors ) {
				EE_Error::add_error(
					__( 'An invalid Registration object was discovered when attempting to save your registration information.', 'event_espresso' ),
					__FILE__, __FUNCTION__, __LINE__
				);
			}
		}
	}



	/**
	 * _save_registration_attendee
	 *
	 * @param 	EE_Registration 	$registration
	 * @param bool $show_errors
	 * @return void
	 */
	private function _save_registration_attendee( $registration, $show_errors = TRUE ) {
		if ( $registration->attendee() instanceof EE_Attendee ) {
			// save so that ATT has ID
			$registration->attendee()->save();
			if ( ! $registration->update_cache_after_object_save( 'Attendee', $registration->attendee() )) {
				if ( $show_errors ) {
					EE_Error::add_error(
						__( 'The newly saved Attendee object could not be cached on the registration.', 'event_espresso' ),
						__FILE__, __FUNCTION__, __LINE__
					);
				}
			}
		} else {
			if ( $show_errors ) {
				ob_start();
				var_dump( $registration->attendee() );
				EE_Error::add_error(
					sprintf(
						'%1$s||%1$s $attendee = %2$s',
						__( 'Either no Attendee information was found, or an invalid Attendee object was discovered when attempting to save your registration information.', 'event_espresso' ),
						ob_get_clean()
					),
					__FILE__, __FUNCTION__, __LINE__
				);
			}
		}
	}



	/**
	 * _save_question_answers
	 *
	 * @param 	EE_Registration 	$registration
	 * @param bool $show_errors
	 * @return void
	 */
	private function _save_registration_answers( $registration, $show_errors = TRUE ) {
		// now save the answers
		foreach ( $registration->answers() as $cache_key => $answer ) {
			// verify object
			if ( $answer instanceof EE_Answer ) {
				$answer->set_registration( $registration->ID() );
				$answer->save();
				if ( ! $registration->update_cache_after_object_save( 'Answer', $answer, $cache_key )) {
					if ( $show_errors ) {
						EE_Error::add_error(
							__( 'The newly saved Answer object could not be cached on the registration.', 'event_espresso' ),
							__FILE__, __FUNCTION__, __LINE__
						);
					}
				}
			} else {
				if ( $show_errors ) {
					EE_Error::add_error(
						__( 'An invalid Answer object was discovered when attempting to save your registration information.', 'event_espresso' ),
						__FILE__, __FUNCTION__, __LINE__
					);
				}
			}
		}
	}



	/**
	 *    refresh_all_entities
	 *    simply loops through the current transaction calling EEM_Base::refresh_entity_map_with() on each object (including the TXN)
	 *
	 * @access public
	 * @return bool
	 */
	public function refresh_all_entities() {
		// verify the transaction
		if ( $this->transaction instanceof EE_Transaction ) {
			// grab the saved registrations from the transaction
			foreach ( $this->transaction->registrations( $this->reg_cache_where_params, TRUE ) as $reg_cache_ID => $registration ) {
				$this->_refresh_registration( $reg_cache_ID, $registration );
			}
			// make sure our cached TXN is added to the model entity mapper
			$this->transaction = $this->transaction->get_model()->refresh_entity_map_with( $this->transaction->ID(), $this->transaction );
		} else {
			EE_Error::add_error( __( 'A valid Transaction was not found when attempting to update the model entity mapper.', 'event_espresso' ), __FILE__, __FUNCTION__, __LINE__);
			return FALSE;
		}
		$this->cart->get_grand_total()->get_model()->refresh_entity_map_with( $this->cart->get_grand_total()->ID(), $this->cart->get_grand_total() );
		return TRUE;
	}


	/**
	 * _refresh_registration
	 *
	 * @param 	string | int 	$reg_cache_ID
	 * @param 	EE_Registration 	$registration
	 * @return void
	 */
	private function _refresh_registration( $reg_cache_ID, $registration ) {
		// verify object
		if ( $registration instanceof EE_Registration ) {
			// update the entity mapper attendee
			$this->_refresh_registration_attendee( $registration );
			// update the entity mapper answers for reg form questions
			$this->_refresh_registration_answers( $registration );
			// make sure the cached registration is added to the model entity mapper
			$registration->get_model()->refresh_entity_map_with( $reg_cache_ID, $registration );
		} else {
			EE_Error::add_error(
				__( 'An invalid Registration object was discovered when attempting to update the model entity mapper.', 'event_espresso' ),
				__FILE__, __FUNCTION__, __LINE__
			);
		}
	}



	/**
	 * _save_registration_attendee
	 *
	 * @param 	EE_Registration 	$registration
	 * @return void
	 */
	private function _refresh_registration_attendee( $registration ) {
		$attendee = $registration->attendee();
		// verify object
		if ( $attendee instanceof EE_Attendee && $attendee->ID() ) {
			// make sure the cached attendee is added to the model entity mapper
			$registration->attendee()->get_model()->refresh_entity_map_with( $attendee->ID(), $attendee );
			// maybe cache primary_attendee_obj ?
			if ( $registration->is_primary_registrant() ) {
				$this->primary_attendee_obj = $attendee;
			}
		}
	}



	/**
	 * _refresh_registration_answers
	 *
	 * @param 	EE_Registration 	$registration
	 * @return void
	 */
	private function _refresh_registration_answers( $registration ) {
		// now update the answers
		foreach ( $registration->answers() as $cache_key => $answer ) {
			// verify object
			if ( $answer instanceof EE_Answer ) {
				if ( $answer->ID() ) {
					// make sure the cached answer is added to the model entity mapper
					$answer->get_model()->refresh_entity_map_with( $answer->ID(), $answer );
				}
			} else {
				EE_Error::add_error(
					__( 'An invalid Answer object was discovered when attempting to update the model entity mapper.', 'event_espresso' ),
					__FILE__, __FUNCTION__, __LINE__
				);
			}
		}
	}



	/**
	 * mark_twain - print debug output
	 * why Mark Twain? Something shouted by crewmen on a Mississippi riverboat to test the depth of the water; a crewman shouts "mark twain!"
	 *
	 * @param $class
	 * @param $func
	 * @param $file
	 * @param $line
	 * @param $extra
	 * @return void
	 */
	function mark_twain( $class, $func, $file, $line, $extra = '' ) {
		if ( EE_Registry::instance()->REQ->front_ajax  ) {
			echo '<br/><span style="color:#2EA2CC;">' . $class . '<span style="font-weight:normal;color:#0074A2"> -> </span>' . $func . '()</span><br/>';
			echo $extra ? $extra . ' <br/>' : '';
			echo '<span style="font-size:9px;font-weight:normal;color:#666">' . $file . '</span>    <b style="font-size:10px;color:#333">  ' . $line . ' </b><br/>';
		}
	}



	/**
	 * 	__wakeup
	 * to conserve db space, we are removing the EE_Checkout object from EE_SPCO_Reg_Step objects upon serialization
	 * this will reinstate the EE_Checkout object on each EE_SPCO_Reg_Step object
	 */
	function __wakeup() {
		foreach ( $this->reg_steps as $reg_step ) {
			$reg_step->checkout = $this;
		}
	}



}
// End of file EE_Checkout.class.php
// Location: /EE_Checkout.class.php