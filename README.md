# Setup Instructions:
1- Import the Database
    
    Execute [atstudio.sql] file

2- Launch application using [php artisan serve]

3- Import Postman Collection

    Import the [Astudio postman apis.json] file into Postman.

4- Define Environment

    - Create a new environment and create new variable inside it called [baseUrlV1].
	- Set [baseUrlV1] to [http://localhost:8000/api] (adjust the port to match your application).

5- Select Environment

	Change the Postman environment to the newly created environment.

6- Access Protected APIs

	- Note that protected APIs require authentication. Call the Auth/login API first to set the authentication token for subsequent requests.
	- Credentials:
		Email: mohtermanini.job@gmail.com
		Pass: Password123

<small>Note: you can always reset the database data using [php artisan migrate:fresh --seed]</small>
