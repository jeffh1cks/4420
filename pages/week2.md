# Week 2 Update
<br/>

## MongoDB
<div id="text">
I downloaded the community version of  MongoDB onto my server and was able to run using "MongoSH." After downloading MongoDB, I experimented with creating a database and adding collections to that database. My ultimate goal was to have collections for "Owners", "NFTs", and "Ledger". 
<br/>
<br/>
I then created the corresponding tables in my SQLITE3 database to a MongoDB database. I used Mongoose to create these schemas.
<br/>
<br/>
"Mongoose is a Node. js-based Object Data Modeling (ODM) library for MongoDB. It is akin to an Object Relational Mapper (ORM) such as SQLAlchemy for traditional SQL databases. The problem that Mongoose aims to solve is allowing developers to enforce a specific schema at the application layer Connect these tables in a way to correctly link them like they were linked in the SQLITE3 database." (Mongoose)
<br/>
<br/>
A big learning curve that I experienced when creating the schema for my tables was trying to link the NFTs with the owners. I knew that NFTs could be owned by owners and in a SQL database you would connect these by use of the foreign key. However, in a NOSQL, like MongoDB, there is no such thing as a foreign key. In my first implementation, I tried to give each collection a unique "id" and that was how I planned to link the two. To be able to correctly auto-increment I implemented another schema, "Counter", to keep track of each unique id as shown **below**. 
Counter initializes all unique identifiers to 0 before the creation of the other schemas. Note that in both the Owner Schema and NFT schema, Counter is included. 
<br/>
<br/>
I later realized that since everything is an object, I could put the list of NFT's for which the owner owned into the owner table. I realized that it was not necessary to store the ownerid in the nft schema as I would not need to link in the same way I did with SQL and foreign keys.
<br/>
<br/>

## Owner Schema: 
![Owners Schema](./images/ownerSchema.png)

## NFT Schema: 
![NFT Schema](./images/nftSchema.png)
<br/>
<br/>


## Counter: 
![Counter Schema](./images/counterSchema.png)


## API: 
Lastly, I began creating an API that can be used to get information from my MongoDB database and use that to display that on my website. This is my distributed database that my website can access. The route to access my apis are:
<br/> 
https://jhicks.3680.com/api/user
<br/>
https://jhicks.3680.com/api/nfts 
<br/>
<br/>
The different API calls I have created so far are:
1. Create User
2. Get All Users
3. Create NFT

<br/>
I used Insomia to test my routes and to make sure my API was returning expected results. Below are images of sample responses bodies when calling that API or the response claiming my document was created. Before using these for my front-end, I will filter the body to only give users the fields they need. 
<br/>
<br/>

![Create Owner](./images/createOwner.png)
![Get Owners](./images/getOwners.png)
![Create NFT](./images/createNFT.png)

</div>

## Next Steps

<div id="text">
I need to create the Ledger table and get the functionality down of the user purchasing an NFT.
<br/>
<br/>
After getting the functionality of my MongoDB working, compare the performance between this database and our database in SQLITE3. Also, compare the two databases when more users and NFTs are added (vertical scaling).
<br/>
<br/>
</div>

## Resources:

<div id="resource-links">

[Lab 2 sqlite3 with PHP](https://csub.instructure.com/courses/24062/assignments/416531)  
   
[MongoDB](https://www.mongodb.com/)  

[Mongoose](https://www.mongodb.com/developer/languages/javascript/mongoose-versus-nodejs-driver/)

[Insomnia](https://insomnia.rest/) 
   
[SQLite](https://www.sqlite.org/about.html)
     
[DigitalOcean | Install Apache on Ubuntu 22.04](https://www.digitalocean.com/community/tutorials/how-to-install-the-apache-web-server-on-ubuntu-22-04#prerequisites)
      
[CertBot](https://certbot.eff.org/instructions?ws=apache&os=ubuntufocal)

[ColorKit](https://colorkit.co/color/0000ff/) 

 </div>






 






