"use strict";
import { Model } from "sequelize";

module.exports = (sequelize, DataTypes) => {
	class UserEmaiAuth extends Model {
		/**
         * Helper method for defining associations.
         * This method is not a part of Sequelize lifecycle.
         * The `models/index` file will call this method automatically.
         */
		static associate(models) {
			// define association here
		}
	}
	UserEmaiAuth.init({
		user_id: DataTypes.STRING
	}, {
		sequelize,
		modelName: "user_email_auth",
	});
	return UserEmaiAuth;
};