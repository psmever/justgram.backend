import * as express from "express";
import ApiBaseMiddleware from "src/middlewares/ApiBaseMiddleware";
import { postRegister } from "src/controllers/v1/AuthController";

const AuthRoute = express.Router();

// TestRoute.post('/admin/signup', verifyAuth, createAdmin);
AuthRoute.post("/register", ApiBaseMiddleware, postRegister);

export default AuthRoute;
