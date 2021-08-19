const express = require('express');
const router = express.Router();
const chaptersHandler = require('./handler/chapters');

router.get('/', chaptersHandler.getAll);
router.get('/:id', chaptersHandler.get);
router.put('/:id', chaptersHandler.update);
router.delete('/:id', chaptersHandler.destroy);
router.post('/', chaptersHandler.create);

module.exports = router;