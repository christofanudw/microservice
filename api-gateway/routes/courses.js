const express = require('express');
const router = express.Router();
const coursesHandler = require('./handler/courses');
const verifyToken = require('../middleware/verifyToken');

router.get('/', coursesHandler.getAll);
router.get('/:id', coursesHandler.get);
router.put('/:id', verifyToken, coursesHandler.update);
router.delete('/:id', verifyToken, coursesHandler.destroy);
router.post('/', verifyToken, coursesHandler.create);

module.exports = router;