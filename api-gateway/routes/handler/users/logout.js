const apiAdapter = require('../../apiAdapter');
const { URL_SERVICE_USER } = process.env;
const api = apiAdapter(URL_SERVICE_USER);

module.exports = async (req,res) => {
    try {
        const userId = req.user.data.id;
        const response = await api.post('/users/logout', { user_id: userId });
        return res.json(response.data);
    } catch (error) {
        if(error.code === 'ERRCONNREFUSED'){
            return res.status(500).json({
                status: 'error',
                message: 'Service unavailable.'
            });
        }
        const { status,data } = error.response;
        return res.status(status).json(data);
    }
}