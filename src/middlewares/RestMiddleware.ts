import { Request, Response, NextFunction } from 'express';

export const RestMiddleware = async (req: Request, res: Response, next: NextFunction) => {
    // TODO: middlewares 개발.

    console.log(typeof req.headers['content-type']);

    // if(typeof req.headers['content-type'] !== 'string' || )

    // if (req.headers['content-type'] !== 'application/json') {
    //     res.status(400).send('Server requires application/json')
    // }

    next();
};
