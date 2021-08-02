module.exports = (sequelize, DataTypes) => {
    const Token = sequelize.define('RefreshToken', {
        id: {
            type: DataTypes.INTEGER,
            primaryKey: true,
            allowNull: false,
            autoIncrement: true,
        },
        token: {
            type: DataTypes.TEXT,
            allowNull: false,
        },
        user_id: {
            type: DataTypes.INTEGER,
            allowNull: false,
        },
        created_at: {
            field: 'created_at',
            type: DataTypes.DATE,
            allowNull: false,
        },
        updated_at: {
            field: 'updated_at',
            type: DataTypes.DATE,
            allowNull: false,
        }
    }, {
        tableName: 'refresh_tokens',
        timeStamps: true,
    });

    return Token;
}