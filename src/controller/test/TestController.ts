import { Request, Response, NextFunction } from 'express';
import Codes from '@src/models/Codes';
import { baseSuccessResponse } from '@common';
import { v4 as uuidv4 } from 'uuid';

// 기본 테스트.
export const Default = async (req: Request, res: Response, next: NextFunction): Promise<void> => {
    baseSuccessResponse(res, {
        uuidv4: uuidv4(),
    });

    next();
};
