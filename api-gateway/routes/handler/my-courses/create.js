const apiAdapter = require('../../apiAdapter');
const { URL_SERVICE_COURSE, HOST_NAME } = process.env;
const api = apiAdapter(URL_SERVICE_COURSE);

module.exports = async (req,res) => {
    try {
        const userId = req.user.data.id;
        const courseId = req.body.course_id;
        const myCourse = await api.post('/api/my-courses', {
            user_id: userId,
            course_id: courseId
        });
        return res.json(myCourse.data);
    } catch (error) {
        if(error.code === 'ECONNREFUSED'){
            return res.status(500).json({ status: 'error', message: 'Service unavailable.' });
        }
        const { status, data } = error.response;
        return res.status(status).json(data)
    }
}