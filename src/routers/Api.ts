import { Router, Request, Response, NextFunction } from 'express';

export const testRouter = Router();

testRouter.post('', async (req: Request, res: Response, next: NextFunction) => {
    try {
        console.log(req);
    } catch (error) {
        console.debug(error);
    }
});
