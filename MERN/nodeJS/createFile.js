// console.log("Hello World!");


//Create a file Using Node Modules
const fs = require("fs");

fs.writeFile("msg.txt", "Hello from NodeJs!", (err)=>{
    if(err) throw err;
    console.log("The file has been saved!");
});