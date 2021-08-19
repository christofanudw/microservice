const express = require('express');
const router = express.Router();
const courseImagesHandler = require('./handler/course-images');

router.delete('/:id', courseImagesHandler.destroy);
router.post('/', courseImagesHandler.create);

module.exports = router;