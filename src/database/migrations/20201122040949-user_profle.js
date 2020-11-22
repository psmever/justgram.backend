'use strict';

module.exports = {
  up: async (queryInterface, Sequelize) => {
    /**
     * Add altering commands here.
     *
     * Example:
     * await queryInterface.createTable('users', { id: Sequelize.INTEGER });
     */
    await queryInterface.createTable('user_profile', {
        id: {
            type: Sequelize.INTEGER,
            allowNull: false,
            autoIncrement: true,
            primaryKey: true
        },
        user_id: {
            type: Sequelize.INTEGER,
            allowNull: false,
            references: { model: 'users', key: 'id' }
        },
        profile_name: {
            type: Sequelize.STRING,
            allowNull: false,
        },
        profile_website: {
            type: Sequelize.STRING,
            allowNull: true,
        },
        profile_bio: {
            type: Sequelize.TEXT,
            allowNull: true,
        },
        profile_gender: {
            type: Sequelize.STRING(6),
            allowNull: true
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
    }).then(
        return queryInterface.addConstraint('Images', ['postId'], {

            type: 'foreign key',

            name: 'custom_fkey_images',

            references: { //Required field

              table: 'Posts',

              field: 'id'

            },

            onDelete: 'cascade',

            onUpdate: 'cascade'

          }
    )
  },

  down: async (queryInterface, Sequelize) => {
    /**
     * Add reverting commands here.
     *
     * Example:
     * await queryInterface.dropTable('users');
     */
  }
};
