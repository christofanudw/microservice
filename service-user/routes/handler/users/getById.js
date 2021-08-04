const { User } = require('../../../models');

module.exports = async (req,res) => {
    const id = req.params.id;
    const user = await User.findByPk(id);

    if(!user){
        return res.status(404).json({
            status: 'error',
            message: 'User not found',
        });
    }

    return res.json({
        status: 'success',
        data: {
            id: user.id,
            name: user.name,
            email: user.email,
            profession: user.profession,
            avatar: user.avatar,
        }
    });
}