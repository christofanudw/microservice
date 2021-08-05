const jwt = require('jsonwebtoken');
const apiAdapter = require('../../apiAdapter');
const {
    URL_SERVICE_USER,
    JWT_SECRET_ACCESS_TOKEN,
    JWT_SECRET_REFRESH_TOKEN,
    JWT_ACCESS_TOKEN_EXPIRES_IN
} = process.env;
const api = apiAdapter(URL_SERVICE_USER);

module.exports = async (req,res) => {
    try {
        const user = await api.post('/refresh_tokens', req.body);
        return res.json(user.data);
    } catch(error) {
        if(error.code === 'ECONNREFUSED'){
            return res.status(500).json({ status: 'error', message: 'Service unavailable.' });
        }
        const { status, data } = error.response;
        return res.status(status).json(data);
    }
}