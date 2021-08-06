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
        const refreshToken = req.body.refresh_token;
        const email = req.body.email;

        if(!refreshToken || !email){
            return res.status(400).json({
                status: 'error',
                message: 'Invalid token.'
            });
        }

        const token = await api.get('/refresh-tokens', { params: { refresh_token: refreshToken } });
        // return res.json({
        //     status: 'success',
        //     message: token.data.token
        // });

        jwt.verify(refreshToken, JWT_SECRET_REFRESH_TOKEN, (err,decoded) => {
            if(err){
                return res.status(403).json({
                    status: 'error',
                    message: err.message
                });
            }

            if(email != decoded.data.email){
                return res.status(400).json({
                    status: 'error',
                    message: 'Email is not valid.'
                });
            }

            const token = jwt.sign({ data: decoded.data }, JWT_SECRET_ACCESS_TOKEN, { expiresIn: JWT_ACCESS_TOKEN_EXPIRES_IN });

            return res.json({
                status: 'success',
                data: {
                    token
                }
            });
        });

    } catch(error) {
        if(error.code === 'ECONNREFUSED'){
            return res.status(500).json({ status: 'error', message: 'Service unavailable.' });
        }
        const { status, data } = error.response;
        return res.status(status).json(data);
    }
}