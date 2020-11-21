import * as express from 'express';
import { postRegister } from 'src/controllers/v1/AuthController';

const AuthRoute = express.Router();

// TestRoute.post('/admin/signup', verifyAuth, createAdmin);
AuthRoute.post('/register', postRegister);

export default AuthRoute;
