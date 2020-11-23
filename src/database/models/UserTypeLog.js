"use strict";
const {
	Model
} = require("sequelize");
module.exports = (sequelize, DataTypes) => {
	class UserTypeLog extends Model {
		/**
         * Helper method for defining associations.
         * This method is not a part of Sequelize lifecycle.
         * The `models/index` file will call this method automatically.
         */
		static associate(models) {
			// define association here
		}
	}
	UserTypeLog.init({
		user_id: DataTypes.STRING
	}, {
		sequelize,
		modelName: "user_type_log",
	});
	return UserTypeLog;
};