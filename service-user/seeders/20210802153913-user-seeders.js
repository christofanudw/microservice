'use strict';
const bcrypt = require('bcrypt');

module.exports = {
  up: async (queryInterface, Sequelize) => {
    await queryInterface.bulkInsert('users', [
      {
        name: 'John Doe',
        profession: 'Admin Micro',
        role: 'admin',
        email: 'john@gmail.com',
        password: await bcrypt.hash('rahasia1234', 10),
        created_at: new Date(),
        updated_at: new Date(),
      },
      {
        name: 'Jane Doe',
        profession: 'Student',
        role: 'student',
        email: 'jane@gmail.com',
        password: await bcrypt.hash('secret1234', 10),
        created_at: new Date(),
        updated_at: new Date(),
      }
    ], {});
  },

  down: async (queryInterface, Sequelize) => {
    await queryInterface.bulkDelete('users', null, {});
  }
};
