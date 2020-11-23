import * as express from "express";
import ApiBaseMiddleware from "src/middlewares/ApiBaseMiddleware";
import { getCheckStatus, getCheckNotice, getBaseData } from "src/controllers/SystemController";

const SystemRoute = express.Router();

SystemRoute.get("/check-status", ApiBaseMiddleware, getCheckStatus);
SystemRoute.get("/check-notice", ApiBaseMiddleware, getCheckNotice);
SystemRoute.get("/base-data", ApiBaseMiddleware, getBaseData);

export default SystemRoute;
