# Week 1 Update
## Completed 
<div id="text">
I created a Ubuntu VM using DigitalOcean and Apache2 to serve the web-content with use of a proxy-pass. I used my domain name given to my server from my CMPS 3680 course and created a route to 4420 where the web application is now hosted. I validated my server by using “CertBot” to now route traffic through SSL.
<br/>
<br/>
I created the navbar and routes dynamically to each page for the project using jQuery and Javascript. I did this by grabbing the params from the url and taking the file to then match it with its corresponding marked down file. I spent a good amount of time designing the layout and look of my site. Color choices were chosen with help of colorkit (listed below in resources). 
<br/>
<br/>
I transported CMPS 4420 Lab 2 onto my server by first downloading both PHP and SQLITE3. I downloaded our source code from Artemis to my server. Once code was downloaded, all the functionality of Lab 2 was now enabled. 
<br/>
<br/>

**CHECK IT OUT:**
<div id="lab2link">

[LAB 2 | JHICKS](https://jhicks.cs3680.com/4420/?page=sql)
</div>
</div>

## Next Steps

<div id="text">
I need to download MongoDB onto my server. 
<br/>
<br/>
Create the corresponding tables in my SQLITE3 database to a MongoDB database. Connect these tables in a way to correctly link them like they were linked in the SQLITE3 database.
<br/>
<br/>
After getting the functionality of my MongoDB working, compare the performance between this database and our database in SQLITE3. Also, compare the two databases when more users and NFTs are added (vertical scaling).
<br/>
<br/>
Lastly, create an API that can be used to get information from my MongoDB database and use that to display that on my website. Essentially this will make a distributed database that my website can access. 
</div>

## Resources:

<div id="resource-links">

[Lab 2 sqlite3 with PHP](https://csub.instructure.com/courses/24062/assignments/416531)  
   
[MongoDB](https://www.mongodb.com/)  
   
[SQLite](https://www.sqlite.org/about.html)
     
[DigitalOcean | Install Apache on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-22-04#prerequisites)
      
[CertBot](https://certbot.eff.org/instructions?ws=apache&os=ubuntufocal)

[ColorKit](https://colorkit.co/color/0000ff/) 

 </div>





