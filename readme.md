Finance


Installation Guide -
	Requirements -
		- Laravel Framework Requirements:
			- PHP >= 7.0.0
			- OpenSSL PHP Extension.
			- PDO PHP Extension.
			- Mbstring PHP Extension.
			- Tokenizer PHP Extension.
			- XML PHP Extension.
			- Composer (getComposer.org).

		- Additional Requirements:
			- None.

	Install Instruction -
		- Make sure you fulfill the requirements listed above
		- Create new file named ".env", copy all contents from ".env.example" to ".env"
		- After downloading open the project directory in the CMD/Terminal.
		- Enter "composer install" in the CMD/Terminal.
		- Enter "php artisan key:generate".
		- Enter "php artisan migrate --seed".
		- Enter "php artisan serve".
		- Go to "localhost:8000/install".