import * as express from "express";
import { statusCode, messages } from "src/common/constants";

export const getCheckStatus = (req: express.Request, res: express.Response) => {
	res.status(statusCode.nocontent).json({
		message: messages.response.success
	});
};

export const getCheckNotice = (req: express.Request, res: express.Response) => {

	console.log(__dirname);







	// TODO : 2020-11-22 22:45  공지사항 처리 어떻게 할껀지?
	res.status(statusCode.nocontent).json({
		message: messages.response.success
	});
};

export const getBaseData = (req: express.Request, res: express.Response) => {
	// TODO: 2020-11-22 22:53 기본 데이터 처리.
};
