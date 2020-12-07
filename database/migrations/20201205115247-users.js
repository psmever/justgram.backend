"use strict";

module.exports = {
	up: async (queryInterface, Sequelize) => {
    /**
     * Add altering commands here.
     */
		await queryInterface.createTable("users", {
			id: {
				type: Sequelize.INTEGER,
				allowNull: false,
				autoIncrement: true,
				primaryKey: true
			},
			user_uuid: {
				type: Sequelize.STRING,
				allowNull: false,
				defaultValue: ""
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
				values: ["Y", "N"],
				allowNull: false,
				defaultValue: "Y"
			},
			profile_active: {
				type: Sequelize.ENUM,
				values: ["Y", "N"],
				allowNull: false,
				defaultValue: "N"
			},
			email_verified_at: {
				type: Sequelize.DATE,
				allowNull: true,
				defalutValue: Sequelize.literal("now()"),
			},
			createdAt: {
				field: "created_at",
				type: "TIMESTAMP",
				defaultValue: Sequelize.literal("CURRENT_TIMESTAMP"),
			},
			updatedAt: {
				field: "updated_at",
				type: "TIMESTAMP",
				defaultValue: Sequelize.literal("CURRENT_TIMESTAMP"),
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
		await queryInterface.dropTable("users");
	}
};
