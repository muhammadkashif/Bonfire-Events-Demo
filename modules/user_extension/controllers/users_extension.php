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
class Users_extension extends Front_Controller {

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

		public function render_user_form( $data )
		{
				$user_id = (int) $data->id;

				$meta = $this->user_model->find_user_and_meta( $user_id );
				$data = array ('user' => $meta );

				echo $this->load->view('user_extension/user_form', $data , true );
		}

		//--------------------------------------------------------------------

	/*
		Method: save_user()

		Saves one or more key/value pairs of additional meta information
		for a user called from System Events.


		Parameters:
			$data		- An array of key/value pairs to save.
	*/
		public function save_user( $data )
		{
				$this->load->helper('array');

				/**
				 * Fetch the User ID, not sure why it's not in the payload? Maybe this needs to be fixed.
				 **/
				$the_user = $this->user_model->select('id')->find_by('email', $data['email']);
				$the_user = (int) $the_user->id;


				/**
				 * @var array   This is the user meta fields, I am using CI's array helper to pull the array keys, I want to use in the meta
				 **/
				$data    = elements( array('street_1', 'street_2', 'city', 'state_code', 'country_iso', 'zipcode', 'editor'), $data );

				$this->user_model->save_meta_for( $the_user, $data );

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

		}

		//--------------------------------------------------------------------

		/*
		  method: before_user_update

		  Called just prior to updating a user. Payload is an array of ‘user_id’ and ‘data’, where data is all of the update information passed into the method.
		*/
		public function after_user_update ( $payload )
		{
				echo var_dump ( $payload );
				die;

		}

	//--------------------------------------------------------------------

}
