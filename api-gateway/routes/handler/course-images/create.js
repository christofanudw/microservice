const apiAdapter = require('../../apiAdapter');
const { URL_SERVICE_COURSE, HOST_NAME } = process.env;
const api = apiAdapter(URL_SERVICE_COURSE);

module.exports = async (req,res) => {
    try {
        const courseImage = await api.post('/api/course-images', req.body);
        return res.json(courseImage.data);
    } catch (error) {
        if(error.code === 'ECONNREFUSED'){
            return res.status(500).json({ status: 'error', message: 'Service unavailable.' });
        }
        const { status, data } = error.response;
        return res.status(status).json(data)
    }
}