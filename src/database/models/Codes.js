"use strict";

import { Model } from "sequelize";

module.exports = (sequelize, DataTypes) => {
	class Codes extends Model {
		/**
         * Helper method for defining associations.
         * This method is not a part of Sequelize lifecycle.
         * The `models/index` file will call this method automatically.
         */
		static associate(models) {
			// define association here
		}
	}
	Codes.init({
		code_id: DataTypes.STRING
	}, {
		sequelize,
		modelName: "codes",
		timestamps: true,
	});
	return Codes;
};