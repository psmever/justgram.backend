import { Request, Response, NextFunction } from 'express';
import { sample } from '@common';

// 기본 테스트.
export const Default = async (req: Request, res: Response, next: NextFunction) => {
    res.json(sample);

    next();
};
