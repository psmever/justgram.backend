'use strict';

module.exports = {
  up: async (queryInterface, Sequelize) => {
    /**
     * Add altering commands here.
     *
     * Example:
     * await queryInterface.createTable('users', { id: Sequelize.INTEGER });
     */
    await queryInterface.createTable('users', {
        id: {
            allowNull: false,
            autoIncrement: true,
            primaryKey: true,
            type: Sequelize.INTEGER
        },
        user_uuid: {
            type: Sequelize.STRING,
            allowNull: false,
            defaultValue: ''
        },
        user_state: {
            type: Sequelize.ENUM('Y', 'N'),
            allowNull: false,
            defaultValue: 'Y'
        },
        user_name: {
            type: Sequelize.STRING,
            allowNull: false,
        },
        email: {
            type: Sequelize.STRING,
            allowNull: false,
            unique: true,

        },
        password: {
            type: Sequelize.STRING,
            allowNull: false,
        },
        email_verified_at: {
            type: Sequelize.DATE,
            allowNull: true,
            defalutValue: Sequelize.literal('now()'),
        },
        created_at: {
            type: Sequelize.DATE,
            allowNull: false,
            defalutValue: Sequelize.literal('now()'),
        },
        updated_at: {
            type: Sequelize.DATE,
            allowNull: false,
            defalutValue: Sequelize.literal('now()'),
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
    await queryInterface.dropTable('users');
  }
};
