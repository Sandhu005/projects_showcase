import express from "express";
import bodyParser from "body-parser";
import { dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));
const app = express();
const port = 3000;
var bandName = "";

app.use(bodyParser.urlencoded({extended: true}));

function bandNameGenerator(req, res, next){
    bandName = req.body["name"] + req.body["pet"];
    next();
}

app.get("/", (req, res) => {
  res.sendFile(__dirname + "/public/index.html");
});

app.use(bandNameGenerator);

app.post("/submit", (req, res)=>{
    res.send(`<h2>Your Band name is: </h2><h3>${bandName}</h3>`);
});

app.listen(port, () => {
  console.log(`Listening on port ${port}.`);
});
