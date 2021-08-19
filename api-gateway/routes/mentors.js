const express = require('express');
const router = express.Router();
const mentorsHandler = require('./handler/mentors')

router.post('/', mentorsHandler.create);
router.put('/:id', mentorsHandler.update);
router.delete('/:id', mentorsHandler.destroy);
router.get('/:id', mentorsHandler.get);
router.get('/', mentorsHandler.getAll);

module.exports = router;