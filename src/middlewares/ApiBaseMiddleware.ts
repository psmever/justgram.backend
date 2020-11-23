import * as express from "express";
import { statusCode } from "src/common/constants";

const ApiBaseMiddleware = async (req: express.Request, res: express.Response, next: express.NextFunction) => {

	console.debug(statusCode.success);
	console.log(typeof req.headers["content-type"]);

	// if(typeof req.headers['content-type'] !== 'string' || )

	// if (req.headers['content-type'] !== 'application/json') {
	//     res.status(400).send('Server requires application/json')
	// }

	next();
};

export default ApiBaseMiddleware;
