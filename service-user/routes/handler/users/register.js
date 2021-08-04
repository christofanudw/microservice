const bcrypt = require('bcrypt');
const { User } = require('../../../models');
const Validator = require('fastest-validator');
const v = new Validator();

module.exports = async (req,res) => {
    /*
    *
    *   Validates the informations provided by user
    *
    */
    const schema = {
        name: 'string|empty:false',
        email: 'email|empty:false',
        password: 'string|min:6',
        profession: 'string|optional',
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
    *   Checks if email already exists in user database
    *
    */
    const user = await User.findOne({
        where: { email: req.body.email }
    });

    if(user){
        return res.status(409).json({
            status: 'error',
            message: 'Email already exists.',
        });
    }

    /*
    *
    *   Hashes password
    * 
    */
    const password = await bcrypt.hash(req.body.password, 10);

    /*
    *
    *   Creates data object
    * 
    */
    const data = {
        name: req.body.name,
        email: req.body.email,
        password,
        role: 'student',
        profession: req.body.profession,
    }

    /*
    *
    *   Inserts data object into database though User model
    *
    */
    const createUser = await User.create(data);

    /*
    *
    *   Returns success response
    * 
    */
    return res.json({
        status: 'success',
        message: 'User added successfully.',
    });
}