const express = require('express');
const router = express.Router();
const coursesHandler = require('./handler/courses');
const verifyToken = require('../middleware/verifyToken');
const can = require('../middleware/permissions');

router.get('/', coursesHandler.getAll);
router.get('/:id', coursesHandler.get);
router.put('/:id', verifyToken, can('admin'), coursesHandler.update);
router.delete('/:id', verifyToken, can('admin'), coursesHandler.destroy);
router.post('/', verifyToken, can('admin'), coursesHandler.create);

module.exports = router;