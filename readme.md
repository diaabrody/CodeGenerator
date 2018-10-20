Description :: RESTful API TO Generate proposal codes .laravelv5.7

Installation :: 
* composer install (command)
*.env.example
* php artisan migrate
* composer dump-autoload (command)
* php artisan db:seed (command)


* Authentication by jwt package. 

* url like this 

*http://localhost/api/user/auth    
(to auth user. post request took two parameter (email) , (password)      and return token  )

********************************************************************************************************************
*http://127.0.0.1:8000/api/user/register
(to register new user. post request took four parameters (email) , (password) , (password_confirmation) ,(name) and return token )

********************************************************************************************************************
*http://127.0.0.1:8000/api/codegenerator/
(post requset (post method) to generate proposal code and insert this code to database with another details take 7 paramters

* (proposal_number) required

* (proposal_type) required

* (technical_name) required

* (client_source) required

* (client_name)  allow null

* (proposal_date)  allow null

* (propsal_value) allow null

) and return the created proposal with generated code


********************************************************************************************************************

* http://127.0.0.1:8000/api/codegenerator/ 

(get request (GET METHod)  return all proposals  as collection resource )


********************************************************************************************************************

http://127.0.0.1:8000/api/codegenerator/{id}

( (Delete METHod)  remove certain proposal ) admin and the sales agent that created the proposal can delete it.

********************************************************************************************************************

http://127.0.0.1:8000/api/codegenerator/{id}

( (GET METHod)  return certain proposal as resource ) 


**********************************************************************************************************************




 

