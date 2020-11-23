import * as express from "express";
import ApiBaseMiddleware from "src/middlewares/ApiBaseMiddleware";
import { getCheckStatus } from "src/controllers/SystemController";

const SystemRoute = express.Router();

// SystemRoute.get('/check-status', ApiBaseMiddleware, getCheckStatus);
SystemRoute.get("/check-status", ApiBaseMiddleware, getCheckStatus);

export default SystemRoute;
