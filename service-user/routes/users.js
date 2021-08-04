const express = require('express');
const router = express.Router();
const usersHandler = require('./handler/users');

/* GET users listing. */
router.get('/', function(req, res, next) {
  res.send('respond with a resource');
});

router.post('/register', usersHandler.register);
router.post('/login', usersHandler.login);

module.exports = router;
