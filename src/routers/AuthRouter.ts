import { Router } from 'express';
import { login } from '@controller/system/AuthController';

export const AuthRouter = Router();

// 로그인
AuthRouter.post('/login', login);
