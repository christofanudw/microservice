const express = require('express');
const router = express.Router();
const ordersHandler = require('./handler/orders');

router.get('/', ordersHandler.getOrders)

module.exports = router;