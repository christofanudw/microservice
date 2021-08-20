module.exports = (...roles) => {
    return (req,res,next) => {
        const role = req.user.data.role;
        if(!roles.includes(role)){
            return res.status(405).json({
                status: 'error',
                message: 'User doesn\'t have permission to access this resource.'
            });
        }
        return next();
    }
}