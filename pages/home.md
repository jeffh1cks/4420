# CMPS 4420 Final Project
### *DATA AS A SERVICE*
#### **Jeff Hicks**  
#### **Spring 2023**  



## Github: 
[Github | 4420 Final Project](https://github.com/jeffh1cks/4420)

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
<br/>

## Owner Schema: 
```javascript
const mongoose = require('mongoose');
const Counter = require('./counterSchema.js');


const ownerSchema = new mongoose.Schema({
  id: { type: Number, required:true, unique: true},
  name: { type: String, required: true },
  nfts: [
    {
      type: mongoose.Schema.Types.ObjectId,
      ref: "Nft"
    }
  ]
});

ownerSchema.pre('validate', function(next) {
  var doc = this;
  Counter.findByIdAndUpdate({_id:'ownerid'}, {$inc: {seq:1}}, {returnDocument: "after"})
    .then((res) => {
      this.id = res.seq;
      next();
    })
})

module.exports = mongoose.model('Owner', ownerSchema);
```

## NFT Schema: 
```javascript
const mongoose = require('mongoose');
const Counter = require('./counterSchema.js');

const nftSchema = new mongoose.Schema({
  id: { type: Number, required: true, unique: true },
  name: { type: String, required: true },
  price: { type: Number, required: true, default: 0.00 },
  createdon: { type: Date, default: Date.now },
  lastbought: { type: Date, default: Date.now },
  payloadtype: { type: String, default: null },
  payloadfilename: { type: String, default: null },
  payload: { type: Buffer, validate: [payloadSizeLimit, 'Payload size limit exceeded'] }
});

function payloadSizeLimit(value) {
  return value.length <= 1048576;
}

nftSchema.pre('validate', function(next) {
  var doc = this;
  Counter.findByIdAndUpdate({_id:'nftid'}, {$inc: {seq:1}}, {returnDocument: "after"})
    .then((res) => {
      console.log(res);
      this.id = res.seq;
      next();
    })
})
module.exports = mongoose.model('Nft', nftSchema);
```

## Ledger Schema: 
```javascript
const mongoose = require('mongoose');
const Counter = require('./counterSchema.js');

const ledgerSchema = new mongoose.Schema({
    id: {type: Number, required: true, unique: true, index: true},
    nftid: {type: Number, required: true, index: true},
    buyerid: {type: Number, required: true, index: true},
    sellerid: {type: Number, default: null, index: true},
    buyerprice: {type: Number, required: true,default: 0.00},
    sellerprice: {type: Number, required: true,default: 0.00},
    sellerdaysowned: {type: Number, default: 0.0},
    changedon: {type: Date, default: Date.now}
});
ledgerSchema.pre('validate', function(next) {
    var doc = this;
    Counter.findByIdAndUpdate({_id:'ledgerid'}, {$inc: {seq:1}}, {returnDocument: "after"})
      .then((res) => {
        this.id = res.seq;
        next();
      })
  })

module.exports = mongoose.model('Ledger', ledgerSchema);
```

## Counter: 
```javascript
const mongoose = require('mongoose');

const counterSchema = new mongoose.Schema({
  _id: { type: String, required: true},
  seq: { type: Number, default: 0}
});

module.exports = mongoose.model('Counter', counterSchema);
```


<br/>

 






