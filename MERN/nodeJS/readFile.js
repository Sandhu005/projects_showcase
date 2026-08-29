
// Reading file using node modules
const fs = require("fs");

fs.readFile("msg.txt", "utf8", (err, data)=> {
    if (err) throw err;
    console.log(data);
});