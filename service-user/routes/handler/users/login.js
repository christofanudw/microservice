const bcrypt = require('bcrypt');
const { User } = require('../../../models');
const Validator = require('fastest-validator');
const v = new Validator();

module.exports = async (req,res) => {
    /*
    *
    *   Validates login informations provided by user
    * 
    */
    const schema = {
       email: 'email|empty:false', 
       password: 'string|min:6',
    }
    
    const validation = v.validate(req.body, schema);
    
    if(validation.length){
        return res.status(400).json({
            status: 'error',
            message: validation,
        });
    };
    
    /*
    *
    *   Retrieves user model from database
    * 
    */
    const user = await User.findOne({
        where: {
            email: req.body.email
        }
    });
    
    if(!user){
        return res.status(404).json({
            status: 'error',
            message: 'User not found.',
        });
    };
    
    /*
    *
    *   Compares provided password w/ user password in database
    * 
    */
    await bcrypt.compare(req.body.password, user.password, (err, result) => {
        if(!result){
            return res.status(404).json({
                status: 'error',
                message: 'User not found.',
            });
        }
        /*
        *
        *   Returns user data as response
        * 
        */
        res.json({
            status: 'success',
            data: {
                id: user.id,
                name: user.name,
                email: user.email,
                role: user.role,
                avatar: user.avatar,
                profession: user.profession,
            }
        });
    });
    
}
