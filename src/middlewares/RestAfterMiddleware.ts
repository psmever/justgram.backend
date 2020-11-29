import { Request, Response, NextFunction } from 'express';

export const RestAfterMiddleware = async (req: Request, res: Response, next: NextFunction) => {
    next();
};
