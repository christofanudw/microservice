const apiAdapter = require('../../apiAdapter');
const {
    URL_SERVICE_USER,
    JWT_SECRET_ACCESS_TOKEN,
    JWT_SECRET_REFRESH_TOKEN,
    JWT_ACCESS_TOKEN_EXPIRES_IN,
    JWT_REFRESH_TOKEN_EXPIRES_IN
} = process.env;
const api = apiAdapter(URL_SERVICE_USER);
const jwt = require('jsonwebtoken');

module.exports = async (req,res) => {
    try {
        const user = await api.post('/users/login', req.body);
        const data = user.data.data;
        const accessToken = jwt.sign({ data }, JWT_SECRET_ACCESS_TOKEN, { expiresIn: JWT_ACCESS_TOKEN_EXPIRES_IN });
        const refreshToken = jwt.sign({ data }, JWT_SECRET_REFRESH_TOKEN, { expiresIn: JWT_REFRESH_TOKEN_EXPIRES_IN });

        await api.post('/refresh_tokens', { token: refreshToken, user_id: data.id })

        return res.json({
            status: 'success',
            data: {
                access_token: accessToken,
                refresh_token: refreshToken
            }
        });
    } catch(error) {
        if(error.code === 'ECONNREFUSED'){
            return res.status(500).json({ status: 'error', message: 'Service unavailable.' });
        }
        const { status, data } = error.response;
        return res.status(status).json(data);
    }
}