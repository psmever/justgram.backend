import { Router } from 'express';
import { Default } from '@controller';

export const TestsRouter = Router();

// 기본 테스트.
TestsRouter.get('/default', Default);
