<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
	Copyright (c) 2012 Shawn Crigger

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in
	all copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
	THE SOFTWARE.
*/

/*
	Class: Users_extension

	Extends front-end functions for users, like additional settings using Bonfire's event system.
	@todo Document the rest of the Events that came from Lonnie's merge and make them work with the meta
*/
class Users_extension extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->CI =& $this;

		if (!class_exists('User_model'))
		{
			$this->load->model('users/User_model', 'user_model');
		}

	}

	//--------------------------------------------------------------------

	/*
	 Method: remap()

	 Method to only allow calls to existing methods.

		Parameters:
			$method		- The method to call
	*/
	public function _remap($method)
	{
		if (method_exists($this, $method))
		{
			$this->$method();
		}
	}

	//--------------------------------------------------------------------

	/*
		Method: render_user_form()

		Finds the user meta information and renders the user meta form.


		Parameters:
			$data		- The user object
	*/
	public function render_user_form( $data )
	{
		$user_id = (int) $data->id;

		$meta = $this->user_model->find_user_and_meta( $user_id );

		$data = array ('user' => $meta );

		echo $this->load->view('user_extension/user_form', $data , true );
	}

	//--------------------------------------------------------------------

	/*
		Method: before_user_validation()

		Is called before form validation of user is run.


		Parameters:
			$data		- array with with user_id and all of post data.
	*/

	public function before_user_validation ( $data )
	{

				$this->form_validation->set_rules('first_name', 'lang:us_first_name', 'required|trim|strip_tags|max_length[20]|xss_clean');
				$this->form_validation->set_rules('last_name', 'lang:us_last_name', 'required|trim|strip_tags|max_length[20]|xss_clean');

				$this->form_validation->set_rules('street_1', 'lang:us_street_1', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('street_2', 'lang:us_street_2', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('city', 'lang:us_city', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('state_code', 'lang:us_state', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('country_iso', 'lang:us_country', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('zipcode', 'lang:us_zipcode', 'trim|strip_tags|max_length[100]|xss_clean');
				$this->form_validation->set_rules('editor', 'Editor', 'trim|strip_tags|max_length[1]|xss_clean');

/*
 This works....
				if ( $this->form_validation->run($this) === false )
				{
								echo validation_errors();
								die ('Failed form validation!');
				}
*/

				log_message('debug', 'before_user_validation has fired');
	}

	/*
		Method: save_user()

		Saves one or more key/value pairs of additional meta information
		for a user called from System Events.


		Parameters:
			$data		- array with with user_id and all of post data.
	*/
	public function save_user( $data )
	{
		$this->load->helper('array');


		/**
		 * Fetch the User ID, not sure why it's not in the payload? Maybe this needs to be fixed.
		 */
		$the_user = $this->user_model->select('id')->find_by('email', $data['email']);
		$the_user = (int) $the_user->id;

		/**
		 * @var array   This is the user meta fields, I am using CI's array helper to pull the array keys, I want to use in the meta
		 **/
		$data    = elements( array('first_name', 'last_name', 'street_1', 'street_2', 'city', 'state_code', 'country_iso', 'zipcode', 'editor'), $data );

		$this->user_model->save_meta_for( $the_user, $data );

		log_message('debug', 'save_user event has finished. Data has been updated.');

	}

	//--------------------------------------------------------------------

	/*
	  method: after_login

	  Called after successful login. Payload is an array of ‘user_id’ and ‘role_id’.
	*/
	public function after_login ( $payload )
	{

	}

	//--------------------------------------------------------------------

	/*
	  method: before_logout

	  Called just before logging the user out. Payload is an array of ‘user_id’ and ‘role_id’.
	*/
	public function before_logout ( $payload )
	{

	}

	//--------------------------------------------------------------------

	/*
	  method: after_create_user

	  Called after a user is created. Payload is the new user’s id.
	*/
	public function after_create_user ( $payload )
	{

	}

	//--------------------------------------------------------------------

	/*
	  method: before_user_update

	  Called just prior to updating a user. Payload is an array of ‘user_id’ and ‘data’, where data is all of the update information passed into the method.
	*/
	public function before_user_update ( $payload )
	{

		echo 'Before user update';
		echo var_dump ( $payload );
		die;

	}

	//--------------------------------------------------------------------

	/*
	  method: before_user_update

	  Called just prior to updating a user. Payload is an array of ‘user_id’ and ‘data’, where data is all of the update information passed into the method.
	*/
	public function after_user_update ( $payload )
	{
	}

	//--------------------------------------------------------------------

	}


	/* End of file user_extension.php */
	/* Location: ./modules/controllers/user_extension/user_extension.php */
