import * as express from "express";
import * as fs from "fs";
import { statusCode, messages } from "src/common/constants";
// import * as db from "src/database/models";

const { Codes } = require("src/database/models");

console.debug(Codes.findAll({}));

export const getCheckStatus = (res: express.Response) => {
	res.status(statusCode.nocontent).json({
		message: messages.response.success
	});
};

export const getCheckNotice = (req: express.Request, res: express.Response) => {

	fs.readFile("storage/server_notice/notice.txt","utf8",function(err, notice){
		if(err || notice === "") {
			res.status(statusCode.nocontent).json({
				message: messages.response.success
			});
		} else {
			res.status(statusCode.success).json({
				notice: notice
			});
		}
	});
};

export const getBaseData = (req: express.Request, res: express.Response) => {
	// TODO: 2020-11-22 22:53 기본 데이터 처리.
	// model migration timestamp 어떻게 할껀지?




	res.status(statusCode.success).json({
		base: "asdasd"
	});
};
