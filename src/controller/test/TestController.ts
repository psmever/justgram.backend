import { Router, Request, Response, NextFunction } from 'express';

export const testRouter = Router();

export const testRouterRootName = 'tests';

/**
 * /api/tests/default
 */

const test = (req: Request, res: Response, next: NextFunction) => {
    next();
};

testRouter.get('/default', test, async (req: Request, res: Response, next: NextFunction) => {
    try {
        // console.log(req);
    } catch (error) {
        // console.debug(error);
    }

    res.json({
        name: 'test-default'
    });

    next();
});
