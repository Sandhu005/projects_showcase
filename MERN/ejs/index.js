import express from "express";

const app = express();
const port = 3000;
var sum = 0;

app.use(express.urlencoded({ extended: true }));

function calculate(req, res, next) {
  let a = (req.body["firstName"]).length;
  let b = (req.body["lastName"]).length;
  sum = a + b;
  next();
}


app.get("/", (req, res) => {
  res.render("index.ejs");
});

app.use(calculate);

app.post("/submit", (req, res) => {
    res.render("index.ejs", {sum});
});

app.listen(port, () => {
  console.log(`Server running at post ${port}`);
});
