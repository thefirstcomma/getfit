# CS4800 Software Engineering - GETFIT
### Authors:
#### Alex Vargas
#### Andrew Kim
#### Aaron Truong

## Project Description/Charter

Our project is based on building a 2D Dress Library where users can import their own dresses, adjust their body sizes, and see how the dress looks on a silhouette with the same body measurements as the user. The user will be able to create their own account and save their body measurements with the dress. This will allow a profile section for users to view and add new dresses as desired. In order to create this application, we leaned towards the web development side and decided to use JavaScript and HTML5 as our framework. For our backend we use SQL and PHP in order to store our body dimensions. We will have one group member assigned as the project leader, one in charge of the front end development, and one in charge of the back end development. Front end developer should be in charge of how the body size of the user changes and how the dress will fit onto their body. Back end developer will determine how to store the dresses and save user information. The project leader will manage project members and keep KanbanFlow sprint sessions updated. Ultimately, our objective is to create a fully functional virtual wardrobe where users are able to visualize a dress on themselves and be content with the results that our website application produces.

## Project Deployment Instructions:

This project was created as a Wordpress plugin.  In order to run this project, you will need to set up a Wordpress site, install this plugin, and activate it to begin use.  Below are tutorials on how to do so:

On Windows: https://www.youtube.com/watch?v=m3RWi-BC_6U

On MacOS: https://www.youtube.com/watch?v=10rsWKEDFvw&t=231s

Once Wordpress has been set up, copy the plugin into the files of the Wordpress directory accordingly:

{wordpress_name} > wp-content > plugins

After the files have been pasted, go over to the admin panel of the Wordpress site, click “Plugins” on the left-hand side of the menu, search for the plugin titled “Virtual Fitting Room” and activate it.  Once that’s been done, the required pages have been created to access the virtual fitting room.  In the URL, add to the end of it “/virtual-fitting-room” to access it.



## Project Release Notes
### *What’s new in Version 1.0.0:*


What’s New: 

Individual dresses can be saved per individual silhouette.
Database has been setup allowing unique individuals to be saved.
Added password protection to username login/authentication.

Bug Fixes:

Images will now position appropriately towards the silhouette. (For the most part)
Multiple users are remembered correctly.
Copy and paste wasn’t working on password properly.
