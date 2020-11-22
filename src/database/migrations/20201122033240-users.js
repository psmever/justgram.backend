'use strict';

module.exports = {
  up: async (queryInterface, Sequelize) => {
    /**
     * Add altering commands here.
     */
    await queryInterface.createTable('users', {
        id: {
            type: Sequelize.INTEGER,
            allowNull: false,
            autoIncrement: true,
            primaryKey: true
        },
        user_uuid: {
            type: Sequelize.STRING,
            allowNull: false,
            defaultValue: ''
        },
        user_name: {
            type: Sequelize.STRING,
            allowNull: false,
        },
        user_password: {
            type: Sequelize.STRING,
            allowNull: false,
        },
        user_email: {
            type: Sequelize.STRING,
            allowNull: false,
            unique: true,
        },
        active: {
            type: Sequelize.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'Y'
        },
        profile_acive: {
            type: Sequelize.ENUM,
            values: ['Y', 'N'],
            allowNull: false,
            defaultValue: 'N'
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
