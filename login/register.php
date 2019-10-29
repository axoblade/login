<?php
require_once 'core/init.php';

if(Input::exists())
{
	if(token::check(Input::get('token'))){
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
			'required' => true,
			'min' => 2,
			'max' => 20,
			'unique' => 'users'
			),
			'password' => array(
			'required' => true,
			'min' => 6
			),
			'password_again' => array(
			'required' => true,
			'matches' => 'password'
			),
			'name' => array(
			'required' => true,
			'min' => 2,
			'max' => 50
			)
		));
		if($validation->passed())
		{
			$user = new User();
			$salt = Hash::salt(32);
			try{
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'group' => 1
				));
				Session::flash('home', 'you have been successfully registered!');
				redirect::to('index.php');
			}
			catch(Exception $e){
				die($e->getMessage());
			}
		}
		else{
			foreach($validation->errors() as $error){
				echo $error, '<br>';
			}
		}
	}
}
?>

<title>Register</title>
</head>
<body>

				<form  method="post">
					

						<input class="input100" type="text" name="username" placeholder="Email or Username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
						
						<input class="input100" type="text" name="name" placeholder=" Full name" id="name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off">
						
						<input class="input100" type="password" name="password" placeholder="Password">
					
						<input class="input100" type="password" name="password_again" placeholder="Password Again" id="password_again">
					
						<button class="login100-form-btn" name="submit">
							Register
						</button>
					
					<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

				
				</form>