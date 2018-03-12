We need the followin components to create the rest api:

• LAMPP.

• Slim Framework: We need to install composer : https://getcomposer.org/download/ 
And then Slim framework:
https://www.slimframework.com/docs/start/installation.html

Then we create the api with the following command: php composer.phar create-project slim/slim-skeleton [my-app-name]


We define in Apache's config that the 'my-app-name' path will be the root directory where we have Slim framework installed. Then when we access through the url http: // my-app-name, this will execute the app. Now let's go to localhost / phpmyadmin and make api-db database, which will have the Hosting table with the following content (Id int autoincrement PK, varchar name, int colors, int memory, int drive).


Once this is done, go to / opt / lampp / htdocs / mi-api / src and in the routes.php file we define the routes to which we will make the requests (POST, GET, DELETE, PUT). And now we go to / opt / lampp / htdocs / mi-api / public and we edit index.php where we will add all the code of the app with the necessary functions and connections.


Hosting function when a GET is made in the URL http: // mi-api / api / v1 / hosting, makes the connection to the database and makes a select all.


Function to add Hostings, we do a POST on http: // mi-api / api / v1 / hosting passing the necessary info to create the hosting and an insert is made to bdd with this data that we have passed


Function to update hostings by doing a PUT at url http: // mi-api / api / v1 / hoting / {id}, this function will take the parameters with the PUT and will do an UPDATE with the data that we have passed.
Finally, we have the function of deleting, which is to make a DELETE on http: // mi-api / api / v1 / hosting / {id} of the hosting, delete the hosting by the id that we have specified by doing a DELETE FROM WHERE ID = {id} in the database.

# mi-api2
