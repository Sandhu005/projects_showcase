//Generating random name using NPM package
var generateName = require('sillyname');
var sillyName = generateName();

console.log(`My Name is ${sillyName}.`);