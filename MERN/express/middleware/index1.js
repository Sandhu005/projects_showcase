import express from "express";
import bodyParser from "body-parser";
import { dirname } from "path";
import { fileURLToPath } from "url";

const __dirname = dirname(fileURLToPath(import.meta.url));
const app = express();
const port = 3000;

//Bodyparser to get values of form
app.use(bodyParser.urlencoded({extended: true}));

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});

//Route pointing to the index page
app.get("/", (req, res) => {
  res.sendFile(__dirname + "/public/index.html");
});

//route for form action
app.post("/submit", (req, res)=>{
    console.log(req.body);
});