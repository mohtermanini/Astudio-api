# Setup Instructions:
1- Import the Database
    
<small> Download [astudio-database.sql] file from the root of this repository or from [here](https://www.dropbox.com/scl/fi/zc6gbok0j32dw23xaphmr/atstudio-database.sql?rlkey=ja7m7sud6cbftgjvdb4s0q71k&st=m0b94mg8&dl=0) then create [astudio] database and execute the sql inside the database.</small>

2- Install dependencies using [composer install] then launch application using [php artisan serve]

3- Import Postman Collection

<small>Download the [Astudio postman apis.json] file from the root of this repository or from [here](https://www.dropbox.com/scl/fi/1ny9akdjzqzf1d800zhs4/Astudio-postman-apis.json?rlkey=uhhtf1r444v7uecuc1kmhz73j&st=9y9kodtb&dl=0) then imported it into Postman.</small>

4- Define Postman Environment

<small>

- Create a new environment inside postman and create new variable inside it called [baseUrlV1].
- Set [baseUrlV1] to [http://localhost:8000/api] (adjust the port to match your application).
</small>

5- Select Postman Environment
<small>
- Change the Postman environment to the newly created environment.
</small>

6- Access Protected APIs

<small>

- Note that protected APIs require authentication. Call the Auth/login API first to automatically set the authentication token for subsequent requests.
- Login credentials:
		Email: mohtermanini.job@gmail.com
		Pass: Password123
</small>

<small>Note: you can always reset the database data using [php artisan migrate:fresh --seed]</small>
