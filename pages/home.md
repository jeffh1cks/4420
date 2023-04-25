# CMPS 4420 Final Project
### *SQLite vs MongoDB Performance*
#### **Jeff Hicks**  
#### **Spring 2023**  

## SQLITE3: 
```sql
CREATE TABLE owner (
    ownerid integer primary key autoincrement,
    ownername text
);

CREATE TABLE nft (
    nftid integer primary key autoincrement,
    ownerid integer default null,
    nftname text,
    price numeric(14, 2) not null default 0.00,
    createdon text default CURRENT_TIMESTAMP,
    lastbought text default CURRENT_TIMESTAMP,
    payloadtype text default null,
    payloadfilename text default null,
    payload blob default null CHECK (length(payload) <= 1048576),
    foreign key (ownerid) references owner(ownerid) on update cascade on delete set null
);

CREATE TABLE ledger (
    ledgerid integer primary key autoincrement,
    nftid integer not null,
    buyerid integer not null,
    sellerid integer default null,
    buyerprice numeric(14, 2) not null default 0.00,
    sellerprice numeric(14, 2) not null default 0.00,
    sellerdaysowned real default 0.0,
    changedon text default CURRENT_TIMESTAMP
);

PRAGMA foreign_keys = ON;
```

## MONGO:


### COMING SOON
<br/>

 






