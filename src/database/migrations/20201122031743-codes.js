'use strict';

module.exports = {
  up: async (queryInterface, Sequelize) => {
    /**
     * Add altering commands here.
     *
     * Example:
     * await queryInterface.createTable('users', { id: Sequelize.INTEGER });
     */

    await queryInterface.createTable('codess', {
        id: {
            allowNull: false,
            autoIncrement: true,
            primaryKey: true,
            type: Sequelize.INTEGER
        },
        group_id: {
            type: Sequelize.STRING(6),
            allowNull: false,
            defaultValue: ''
        },
        code_id: {
            type: Sequelize.STRING(6),
            allowNull: false,
            defaultValue: ''
        },
        group_name: {
            type: Sequelize.STRING(100),
            allowNull: false,
            defaultValue: ''
        },
        code_name: {
            type: Sequelize.STRING(100),
            allowNull: false,
            defaultValue: ''
        },
        active: {
            type: Sequelize.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'Y'
        }
    });
  },

  down: async (queryInterface, Sequelize) => {
    /**
     * Add reverting commands here.
     *
     * Example:
     * await queryInterface.dropTable('users');
     */
    await queryInterface.dropTable('codes');
  }
};
