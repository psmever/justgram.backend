import * as express from "express";

// export const postRegister = (req: express.Request, res: express.Response, next: express.NextFunction) => {
export const getTest = (req: express.Request, res: express.Response) => {
	res.json({
		controller : "TestController"
	});
};