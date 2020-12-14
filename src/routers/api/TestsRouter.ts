import { Router } from 'express';
import { Default } from '@controller/api/test/TestController';
import passport from 'passport';

export const TestsRouter = Router();

// 기본 테스트.
TestsRouter.get('/default', passport.authenticate('jwt', { session: false }), Default);
