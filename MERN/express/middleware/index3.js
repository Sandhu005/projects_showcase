import express from "express";

const app = express();
const port = 3000;

//Custom middleware function
function logger(req, res, next) {
  console.log("Request Method: ", req.method);
  console.log("Request URL: ", req.url);
  next();
}

//using custom middleware
app.use(logger);

app.get("/", (req, res) => {
  res.send("Hello world!!");
});

app.listen(port, () => {
  console.log(`Listening on port ${port}`);
});
