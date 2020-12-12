import { Router } from 'express';
import { login, register } from '@controller/system/AuthController';

export const AuthRouter = Router();

// 로그인
AuthRouter.post('/login', login);

AuthRouter.post('/register', register);
